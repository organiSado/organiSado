SELECT	datos_eventos_invitado_con_cant_invitados.name,
		datos_eventos_invitado_con_cant_invitados.location,
		datos_eventos_invitado_con_cant_invitados.date,
		datos_eventos_invitado_con_cant_invitados.admin,
		confirmados.cant_confirmados,
		datos_eventos_invitado_con_cant_invitados.cant_invitados
FROM
    (SELECT datos_eventos_invitado.name,
            datos_eventos_invitado.location,
            datos_eventos_invitado.date,
            datos_eventos_invitado.admin,
            invitados_por_evento.cant_invitados,
            datos_eventos_invitado.id
    FROM
        (SELECT *
		FROM
			organisado.events
		RIGHT JOIN 
			(SELECT *
			FROM
				organisado.invitees
			WHERE
				email = 'email2') AS eventos_invitado
		ON
			events.id = eventos_invitado.event) AS datos_eventos_invitado
    INNER JOIN
		(SELECT 
			COUNT(*) AS cant_invitados,
			event
		FROM
			organisado.invitees
		GROUP BY event) AS invitados_por_evento
	ON (datos_eventos_invitado.id = invitados_por_evento.event)) AS datos_eventos_invitado_con_cant_invitados
INNER JOIN
	(SELECT 
		COUNT(CASE confirmed WHEN 1 THEN 1 ELSE NULL END) AS cant_confirmados,
		event
    FROM
        organisado.invitees GROUP BY event) AS confirmados
ON datos_eventos_invitado_con_cant_invitados.id = confirmados.event;
