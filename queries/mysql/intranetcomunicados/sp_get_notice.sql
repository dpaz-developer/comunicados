USE intranetcomunicadostest;


-- creamos el stored para obtener la informacion de la noticia individual
DROP PROCEDURE IF EXISTS sp_get_nota;
DELIMITER //
CREATE PROCEDURE sp_get_nota (
	IN v_id INT
)
BEGIN
	SELECT id, title, body, summary, sectionId, dateRegistration, dateUpdate, status, userLoadId, urlImageMain
	FROM notices
	WHERE id = v_id;
END//
DELIMITER ;

-- CALL sp_get_nota (NULL);