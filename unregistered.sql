DROP FUNCTION unregistered();
CREATE OR REPLACE FUNCTION unregistered() RETURNS table(id integer,hostname varchar(50),
macaddress varchar(18),ipaddress varchar(50),last_seen timestamp) AS $$
select id,hostname,macaddress,ipaddress,last_seen from lnm.connected c
	where c.macaddress not in (
	select d.macaddress
	from lnm.device d
	)
	order by c.hostname;

$$ LANGUAGE SQL;

select * from unregistered()
