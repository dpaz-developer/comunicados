USE intranetcomunicadostest;

SELECT * 
FROM sections;

-- actializamos los nombres de la secciones

UPDATE sections SET section = 'LO MÁS NUEVO' WHERE id = 1;
UPDATE sections SET section = 'LO MÁS DESTACADO' WHERE id = 2;
UPDATE sections SET section = 'CALENDARIO DE CIERRE DE MES' WHERE id = 3;

UPDATE sections SET status='deactive' WHERE id = 4;
