SELECT	events.name,
		events.location,
		events.date,
		events.admin,
		confirmados.cant_confirmados,
		events.cant_invitados
FROM
	(SELECT events.name, events.location, events.date, events.admin, invitees.cant_invitados, events.id
	FROM
		(SELECT * FROM
			organisado.events
		RIGHT JOIN
			(SELECT * FROM organisado.invitees WHERE email='email2') AS eventos_invitado
		ON
			events.id=eventos_invitado.event) AS events
	INNER JOIN 
		(SELECT COUNT(*) AS cant_invitados, event FROM
			organisado.invitees GROUP BY event) AS invitees
	ON
		(events.id=invitees.event) ) AS events
INNER JOIN 
	(SELECT 
		COUNT(CASE confirmed WHEN 1 THEN 1 ELSE NULL END) AS cant_confirmados, event
	FROM
		organisado.invitees GROUP BY event) AS confirmados
ON
	events.id=confirmados.event;
