USE intranetcomunicadostest;
-- agregamos un stored para obtener el numero de notas por seccion 
DROP PROCEDURE IF EXISTS sp_get_total_notices;
DELIMITER //
CREATE PROCEDURE sp_get_total_notices (
	IN v_sectionId INT,
	IN v_status VARCHAR(50),
	IN v_query VARCHAR(200)
)
BEGIN
	IF (v_sectionId = 0) THEN
		BEGIN
			SELECT COUNT(id) AS total
			FROM notices
			WHERE status = v_status AND title LIKE CONCAT('%', v_query,'%');
		END;
		ELSE
		BEGIN
			SELECT COUNT(id) AS total
			FROM notices
			WHERE status = v_status AND sectionId = v_sectionId AND title LIKE CONCAT('%', v_query,'%');
		END;
	END IF;
END//
DELIMITER ;

-- CALL sp_get_total_notices (0, 'active', 'sport city');

-- Agregamos un stored procedure para las busquedas  por seccion_id y busquedas por texto

DROP PROCEDURE IF EXISTS sp_get_search_notice;
DELIMITER //
CREATE PROCEDURE sp_get_search_notice (
	IN v_query VARCHAR(200),
	IN v_seccionId INT,
	IN v_status VARCHAR(50),
	IN v_tamanioPagina INT,
	IN v_offset INT
)
BEGIN

	SET @v_skip=v_offset; 
	SET @v_numrows=v_tamanioPagina;
	SET @v_status = v_status;
	SET @v_sectionId = v_seccionId;
	SET @v_query = v_query;
	
	IF (v_seccionId = 0) THEN
		BEGIN
			SET @s_query =  CONCAT('SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain 
	 FROM notices
	 WHERE status=''',@v_status,''' AND  title LIKE  ''','%', @v_query,'%''
	 ORDER BY dateRegistration DESC, id DESC 
	 LIMIT  ',@v_skip,',',@v_numrows) ;
	
		END;
		ELSE
			BEGIN
		SET @s_query =  CONCAT('SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain 
	 FROM notices
	 WHERE status=''',@v_status,''' AND sectionId=',@v_sectionId,' AND title LIKE  ''','%', @v_query,'%''
	 ORDER BY dateRegistration DESC, id DESC 
	 LIMIT  ',@v_skip,',',@v_numrows) ;
	
		END;
	END IF;
	
	PREPARE STMT FROM @s_query;
	EXECUTE STMT;
	DEALLOCATE PREPARE STMT;
END//

DELIMITER ;

-- CALL sp_get_search_notice ('', 0, 'active', 10, 0);

