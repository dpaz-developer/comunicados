use intranetcomunicadostest;
-- creamos tabla de secciones
DROP TABLE IF EXISTS sections;
CREATE TABLE sections (
	id int not null primary key auto_increment,
	section varchar(100),
	status varchar(20),
	dateRegistration datetime
);
-- creamos tabla de noticias
DROP TABlE IF EXISTS notices;
CREATE TABLE notices (
	id int not null primary key auto_increment,
	title varchar(400) charset utf8,
	body mediumText charset utf8,  -- revisar si es Text o MediumText LongText
	summary text charset utf8,
	sectionId int not null,
	dateRegistration TIMESTAMP,
	dateUpdate TIMESTAMP ,
	dateOff TIMESTAMP,
	status varchar(50),
	userLoadId int,
	urlImageMain varchar(300)
);

-- le asignamos un indice de busqueda
ALTER TABLE notices ADD FULLTEXT(title);

-- creaos tabla de usuarios
DROP TABLE IF EXISTS users;
CREATE TABLE users(
	id int not null primary key auto_increment,
	name varchar(50),
	email varchar(50),
	password char(32),
	status varchar(20),
	dateRegistration TIMESTAMP,
	dateUpdate datetime,
	userType nvarchar(30)
);


-- creamos store_procedure para crear secciones

DROP PROCEDURE IF EXISTS sp_set_sections;
DELIMITER //
CREATE PROCEDURE sp_set_sections (
IN sectionName varchar(100)
)
BEGIN
		IF NOT EXISTS (SELECT id FROM sections WHERE section = sectionName) THEN
			INSERT INTO sections (section, dateRegistration, status) VALUES (sectionName, now(), 'active');
			SELECT id, section, status FROM sections WHERE id = last_insert_id();
		ELSE
			SELECT id, section, status FROM sections WHERE section = sectionName;
		END IF;
END//
DELIMITER ;

-- insertamos las secciones
CALL sp_set_sections('avisos');
CALL sp_set_sections('lo que tenemos que cumplir');
CALL sp_set_sections('lo que queremos comunicar');
CALL sp_set_sections('lo que debemos saber');



-- creacion de sp para insertar notas

DROP PROCEDURE IF EXISTS sp_set_nota;
DELIMITER //
CREATE PROCEDURE sp_set_nota (
	IN v_title varchar(400),
	IN v_body varchar(4000),
	IN v_summary varchar(2000),
	IN v_sectionId int,
	IN v_status varchar(50),
	IN v_userLoadId int,
	IN v_urlImageMain varchar(300)
)
BEGIN
	DECLARE idNotice INT;
	IF NOT EXISTS (SELECT id FROM notices WHERE title = v_title AND sectionId = v_sectionId) THEN
	BEGIN
		INSERT INTO notices (title, body, summary, sectionId,dateRegistration, status, userLoadId, urlImageMain)
		VALUES (v_title, v_body, v_summary, v_sectionId, now(), v_status, v_userLoadId, v_urlImageMain);
		
		SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain
		FROM notices
		WHERE id = last_insert_id();
	END;
	ELSE
	BEGIN
		SET idNotice = (SELECT id FROM notices WHERE title = v_title AND sectionId = v_sectionId LIMIT 1);
		
		UPDATE notices SET title=v_title, body=v_body, summary=v_summary, sectionId=v_sectionId,
		dateUpdate=now(), status=v_status, urlImageMain=v_urlImageMain
		WHERE id = idNotice;
		
		SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain
		FROM notices
		WHERE id = idNotice;
	END;
	END IF;
	
END//
DELIMITER ;

-- Insertamos algunas notas de prueba
CALL sp_set_nota ( 'Tenemos todo para que cumplas tus metas', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Servicios-SC-300x208.jpg');
CALL sp_set_nota ( 'Todo nuestro reconocimiento y apoyo a Nahila', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió en 2012 en la primera mujer iberoamericana en completar el serial de los 4 desiertos más extremos del planeta (Racing the Planet).', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Nahila-300x208.jpg');
CALL sp_set_nota ( 'Ya tenemos los resultados del Sport City Tour 2015', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Arrancamos con todo este 2016 recordando los intensos momentos que vivimos en el 2015. Ya tenemos los resultados de las',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Sport-City-Tour-300x208.jpg');
CALL sp_set_nota ( 'Con Razones de Peso alcanza tu peso ideal y ayuda a quien más lo necesita', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Razones de Peso nace con el propósito de motivar a nuestros Socios a alcanzar su peso ideal, reconocer su esfuerzo ',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/imagen-blog-300x208.jpg');
CALL sp_set_nota ( 'Prepárate y conquista el éxito con las Certificaciones de Sport City University', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Sabemos que entre tus propósitos de año nuevo está el prepararte mejor, por esta razón traemos para ti las certificaciones',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Certificaciones-SCU-300x208.jpg');
CALL sp_set_nota ( 'La nutrición y su relación con el deporte', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'El deporte es una actividad con múltiples beneficios a nivel orgánico-funcional. Por ejemplo, nos ayuda a mantenernos en forma, a',1, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/07-blog-alimentacionydeporte-300x208.jpg');
CALL sp_set_nota ( 'Tenemos todo para que cumplas tus metas', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Servicios-SC-300x208.jpg');
CALL sp_set_nota ( 'Todo nuestro reconocimiento y apoyo a Nahila', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió en 2012 en la primera mujer iberoamericana en completar el serial de los 4 desiertos más extremos del planeta (Racing the Planet).', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Nahila-300x208.jpg');
CALL sp_set_nota ( 'Ya tenemos los resultados del Sport City Tour 2015', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Arrancamos con todo este 2016 recordando los intensos momentos que vivimos en el 2015. Ya tenemos los resultados de las',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Sport-City-Tour-300x208.jpg');
CALL sp_set_nota ( 'Con Razones de Peso alcanza tu peso ideal y ayuda a quien más lo necesita', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Razones de Peso nace con el propósito de motivar a nuestros Socios a alcanzar su peso ideal, reconocer su esfuerzo ',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/imagen-blog-300x208.jpg');
CALL sp_set_nota ( 'Prepárate y conquista el éxito con las Certificaciones de Sport City University', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Sabemos que entre tus propósitos de año nuevo está el prepararte mejor, por esta razón traemos para ti las certificaciones',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Certificaciones-SCU-300x208.jpg');
CALL sp_set_nota ( 'La nutrición y su relación con el deporte', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'El deporte es una actividad con múltiples beneficios a nivel orgánico-funcional. Por ejemplo, nos ayuda a mantenernos en forma, a',2, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/07-blog-alimentacionydeporte-300x208.jpg');
CALL sp_set_nota ( 'Tenemos todo para que cumplas tus metas', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Servicios-SC-300x208.jpg');
CALL sp_set_nota ( 'Todo nuestro reconocimiento y apoyo a Nahila', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió en 2012 en la primera mujer iberoamericana en completar el serial de los 4 desiertos más extremos del planeta (Racing the Planet).', 'Considerada como una de las mejores ultramaratonistas del mundo, especialidad 160 kilómetros o más, la mexicana Nahila Hernández, se convirtió',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Nahila-300x208.jpg');
CALL sp_set_nota ( 'Ya tenemos los resultados del Sport City Tour 2015', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Arrancamos con todo este 2016 recordando los intensos momentos que vivimos en el 2015. Ya tenemos los resultados de las',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Sport-City-Tour-300x208.jpg');
CALL sp_set_nota ( 'Con Razones de Peso alcanza tu peso ideal y ayuda a quien más lo necesita', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Razones de Peso nace con el propósito de motivar a nuestros Socios a alcanzar su peso ideal, reconocer su esfuerzo ',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/imagen-blog-300x208.jpg');
CALL sp_set_nota ( 'Prepárate y conquista el éxito con las Certificaciones de Sport City University', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'Sabemos que entre tus propósitos de año nuevo está el prepararte mejor, por esta razón traemos para ti las certificaciones',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/Certificaciones-SCU-300x208.jpg');
CALL sp_set_nota ( 'La nutrición y su relación con el deporte', 'Comenzar el año con nuevos propósitos como un cambio en tu imagen, volver a lucir varios años más joven, o por qué no, simplemente mantenerte saludable y con buen balance mente-cuerpo, es sin lugar a duda comenzar con el pie derecho. Sin embargo más importante que el “¿qué deseas?”, es el “¿cómo piensas alcanzarlo?”.  Para este momento tan especial de renovación y nuevos propósitos lo importante es saber que cada día en tu club,  cada sesión de entrenamiento y  cada visita a la alberca aportaron ese granito de arena necesario para transformar en hechos tus deseos.', 'El deporte es una actividad con múltiples beneficios a nivel orgánico-funcional. Por ejemplo, nos ayuda a mantenernos en forma, a',3, 'active', 1, 'http://blogsportcity.com.mx/wp-content/uploads/2016/01/07-blog-alimentacionydeporte-300x208.jpg');


-- agregamos un stored para obtener el numero de notas por seccion 
DROP PROCEDURE IF EXISTS sp_get_total_notices;
DELIMITER //
CREATE PROCEDURE sp_get_total_notices (
	IN v_sectionId INT,
	IN v_status VARCHAR(50),
	IN v_query VARCHAR(200)
)
BEGIN
	SELECT COUNT(id) AS total
	FROM notices
	WHERE status = v_status AND sectionId = v_sectionId AND title LIKE CONCAT('%', v_query,'%');
END//
DELIMITER ;


-- Agregamos un stored procedure para dar de baja las noticias
DROP PROCEDURE IF EXISTS sp_update_status_notice;
DELIMITER //
CREATE PROCEDURE sp_update_status_notice (
	IN v_id INT,
	IN v_status VARCHAR(50)
)
BEGIN
	UPDATE notices SET status = v_status WHERE id = v_id;
	SELECT id, status
	FROM notices
	WHERE id  = v_id;
END//
DELIMITER ;


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
	
	SET @s_query =  CONCAT('SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain 
	 FROM notices
	 WHERE status=''',@v_status,''' AND sectionId=',@v_sectionId,' AND title LIKE  ''','%', @v_query,'%''
	 ORDER BY dateRegistration DESC, id DESC 
	 LIMIT  ',@v_skip,',',@v_numrows) ;
	
	PREPARE STMT FROM @s_query;
	EXECUTE STMT;
	DEALLOCATE PREPARE STMT;
END//
DELIMITER ;


-- fin del script inicial










