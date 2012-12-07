#This file MUST be run with root privledges: sudo ./scanner.py
#Scapy must be installed: http://www.secdev.org/projects/scapy/doc/installation.html

#!/usr/bin/env python
import os
import datetime
import sys, psycopg2
from scapy.all import srp,Ether,ARP,conf
from optparse import OptionParser

"""This function goes through the IP Address Range of Network
Packet is sent to each IP Address
Returns a list of mac & ip addresses"""
def arping(ip_range):
    ip_range+='/24'
    #ip_range = "152.76.10.0/24"
    conf.verb= 0
    ans,unans=srp(Ether(dst="ff:ff:ff:ff:ff:ff")/ARP(pdst=ip_range),
              timeout=2,inter=0.1)
    devices = []
    for snd, rcv in ans:
        device = rcv.sprintf(r"%ARP.psrc% %Ether.src%").split()

        #get current timestamp

        n=datetime.datetime.now()
        device.append(n.isoformat())
        devices.append(device)
    return devices


"""This function will insert the newly found devices into the connected database
All devices not seen for more than 30 minutes, will be deleted from connected database
"""
def insert_devices(devices,dbname,user,server,password,port):
    try:
        #DEBUG TO SEE IF WE GET A RIGHT LIST FROM ARP
        print 'devices:'
        for d in devices:
          print d 

        #END DEBUG
        database_entry = "dbname='"
        database_entry += dbname
        database_entry += "' user='"
        database_entry += user
        database_entry += "' host='"
        database_entry += server
        database_entry += "' password='"
        database_entry += password
        database_entry += "' port='"
        database_entry += port
        database_entry += "'"
        #Create postgres connection
        conn = psycopg2.connect(database_entry)
        cursor = conn.cursor()
        
        #Drop all the previous records before inserting
        cursor.execute("DELETE FROM lnm.connected;")

        # INSERT Devices into Connected table
        for device in devices:
            if (len(device[0]) > 0 and len(device[1]) > 0): #Check that there is data before we insert
                cursor.execute("INSERT INTO lnm.connected(hostName, macAddress, ipAddress,lastseen) VALUES (%s, %s, %s, %s)", (device[0],device[1],device[0],device[2]))
        
        print "Succesfully added devices"
        conn.commit()  
    except:
        # Get the most recent exception
        exceptionType, exceptionValue, exceptionTraceback = sys.exc_info()
        # Exit the script and print an error telling what happened.
        sys.exit("Database connection failed!\n ->%s" % (exceptionValue))


"""Main function - Finds new devices and then inserts them into database"""
if __name__ == '__main__':
    #get the args and options from the command line
    #get the ip range
    parser = OptionParser()
    parser.add_option("-i", "--ip", dest="ip_range",
                      help="write report to FILE", metavar="IPRANGE",
                      type="string",default="152.76.10.0")
    #get the database name
    parser.add_option("-d", "--database", dest="database",
                      help="database name for your postgres server", 
                      metavar="DATABASE",type="string",default="lnm")
    #get the host for postgres database
    #did not make it -h intending to avoid conflicts with --help
    parser.add_option("-s", "--server", dest="server",
                      help="host name for your postgres server", 
                      metavar="SERVER",type="string",default="localhost")
    #get the user name for postgres database
    parser.add_option("-u", "--user", dest="user",
                      help="user name for your postgres server",
                      metavar="USER",type="string",default="postgres")
    #get the password for the postgres server account
    parser.add_option("-p", "--password", dest="password",
                      help="password to your postgres server",
                      metavar="PASSWORD",type="string")
    #get the port number for the database server
    parser.add_option("-t", "--port", dest="port",
                      help="port to your postgres server",
                      metavar="PORT",type="string",default="5433")
    (options,args) = parser.parse_args()
    os.system("echo \"Local network scanning is running now.\"")
    os.system("echo \"To stop scanning, please simply kill this process.\"")
    #start scanning iterations
    while(True):
      devices = arping(options.ip_range) 
      #Demo output: [['10.0.2.2', '52:54:00:12:35:02'], ['10.0.2.3', '52:54:00:12:35:03'], ['10.0.2.4', '52:54:00:12:35:04']]
      #For e.g. devices[0][0] will print IP Address, devices[0][1] will print MAC Address
      insert_devices(devices,dbname=options.database,server=options.server,
        user=options.user,password=options.password,port=options.port)
