USE intranetcomunicadostest;

SELECT * 
FROM notices;


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
	urlImageMain varchar(300),
    urlImageDetail varchar(300)
);


DROP PROCEDURE IF EXISTS sp_set_nota;
DELIMITER //
CREATE PROCEDURE sp_set_nota (
	IN v_title varchar(400),
	IN v_body varchar(4000),
	IN v_summary varchar(2000),
	IN v_sectionId int,
	IN v_status varchar(50),
	IN v_userLoadId int,
	IN v_urlImageMain varchar(300),
	IN v_urlImageDetail varchar(300)
)
BEGIN
	DECLARE idNotice INT;
	IF NOT EXISTS (SELECT id FROM notices WHERE title = v_title AND sectionId = v_sectionId) THEN
	BEGIN
		INSERT INTO notices (title, body, summary, sectionId,dateRegistration, status, userLoadId, urlImageMain, urlImageDetail)
		VALUES (v_title, v_body, v_summary, v_sectionId, now(), v_status, v_userLoadId, v_urlImageMain, v_urlImageDetail);
		
		SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain
		FROM notices
		WHERE id = last_insert_id();
	END;
	ELSE
	BEGIN
		SET idNotice = (SELECT id FROM notices WHERE title = v_title AND sectionId = v_sectionId LIMIT 1);
		
		UPDATE notices SET title=v_title, body=v_body, summary=v_summary, sectionId=v_sectionId,
		dateUpdate=now(), status=v_status, urlImageMain=v_urlImageMain, urlImageDetail = v_urlImageDetail
		WHERE id = idNotice;
		
		SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain, urlImageDetail
		FROM notices
		WHERE id = idNotice;
	END;
	END IF;
	
END//
DELIMITER ;


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
			SET @s_query =  CONCAT('SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain, urlImageDetail
	 FROM notices
	 WHERE status=''',@v_status,''' AND  title LIKE  ''','%', @v_query,'%''
	 ORDER BY dateRegistration DESC, id DESC 
	 LIMIT  ',@v_skip,',',@v_numrows) ;
	
		END;
		ELSE
			BEGIN
		SET @s_query =  CONCAT('SELECT id, title, body, summary, sectionId, dateRegistration, status, userLoadId, urlImageMain, urlImageDetail
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




-- creamos el stored para obtener la informacion de la noticia individual
DROP PROCEDURE IF EXISTS sp_get_nota;
DELIMITER //
CREATE PROCEDURE sp_get_nota (
	IN v_id INT
)
BEGIN
	SELECT id, title, body, summary, sectionId, dateRegistration, dateUpdate, status, userLoadId, urlImageMain, urlImageDetail
	FROM notices
	WHERE id = v_id;
END//
DELIMITER ;

-- CALL sp_get_nota (NULL);

-- cargamos las notas con el stored creado

CALL sp_set_nota ( 'Nombramientos Sport City', 'Estimados compañeros, 
 
Tenemos el agrado de informarles los recientes nombramientos en la 
Estructura Organizacional de Sport City. 
 
 
Manolo Pérez y López, quien se desempeñaba como Gerente Regional 
de clubes, ha sido promovido al puesto de Sub Director Deportivo de 
Sport City.
 
Jorge Rodríguez Prado, quien ocupaba el puesto  como Gerente Deportivo,
 ahora asumirá nuevos retos a cargo de la Gerencia de Innovación Deportiva.
 
 
Les deseamos mucho éxito en sus nuevas funciones y les mandamos una 
gran felicitación.
 
Sabemos que contamos con el apoyo de la organización para seguir 
trabajando en Equipo y lograr los objetivos que nos hemos planteado.
','Estimados compañeros, 
 
Tenemos el agrado de informarles los recientes nombramientos en la 
Estructura Organizacional de Sport City.',4, 'active',1, 'images/noticias/Nombramientos.jpg', 'images/noticias/Nombramientos.jpg');


--

CALL sp_set_nota ( '¡Qué no te dé frío!', 'Lleva imagen ','Utiliza tu cupón de staff y compra tu chamarra en Martí.mx ',3, 'active',1, 'images/noticias/frío.jpg', 'images/noticias/frío.jpg');
CALL sp_set_nota ( 'Feliz día del nutriólogo ', 'Lleva imagen ','Sport City felicita a todos nuestros  nutriolog@s ',3, 'active',1, 'images/noticias/día del nutrilogo.jpg', 'images/noticias/día del nutrilogo.jpg');
CALL sp_set_nota ( 'SCUcharlas 27 de enero ', 'Lleva imagen ','¡Sport City University   desea que sigas aprendiendo y  te invita  a  SCU Charlas ¡',4, 'active',1, 'images/noticias/SCUcharla 27 de enero.jpg', 'images/noticias/SCUcharla 27 de enero.jpg');
CALL sp_set_nota ( 'Carta de no conflicto de interés ', 'Nuevamente les recordamos que HOY es la fecha límite para entregar la Carta de Declaración de No Conflicto de Interés, a la Oficina de Cumplimiento de la Dirección Corporativa (Piso 6). 

Por otro lado, les recuerdo que la relación de conflicto de interés también es con proveedores, contratistas, prestadores de servicio y/o personas o empresa que tengan relación comercial o laboral con Grupo Martí. 

Saludos cordiales,
Comunicación Interna 

',' HOY ÚLTIMO DÍA PARA ENTREGAR CARTA DE DECLARACIÓN DE NO CONFLICTO DE INTERÉS',2, 'active',1, 'images/noticias/.jpg', 'images/noticias/.jpg');
CALL sp_set_nota ( 'Lanzamiento nueva imagen ED', 'Lleva imagen ','Compartimos contigo nuestra nueva imagen ¡Conócela Aquí!',3, 'active',1, 'images/noticias/comunicado-12.jpg', 'images/noticias/comunicado-12.jpg');
CALL sp_set_nota ( 'Código de vestimenta ', 'lleva archivo adjunto ','Atención Staff:
A partir de mañana 21 de enero del 2015 entra en vigencia el Código de Vestimenta  e Imagen de Corporativo de Grupo Martí.
Es importante que lo descargues, te actualices y cumplas con la vestimenta e imagen de Grupo Martí. 
',2, 'active',1, 'images/noticias/vestimenta.jpg', 'images/noticias/vestimenta.jpg');
CALL sp_set_nota ( 'Calendario cierre de enero de 2016', 'Como parte de la integración de la contraloría de tiendas y clubes les enviamos un calendario único para el cierre contable de enero 2016 por lo que es aplicable a todas las empresas de Grupo Marti: Deportes Marti, Sport City, Icon Fitness de México, Italy Sport Products, Proitaly Mark, Grupo Marti, Administradoras e Inmobiliarias.


Solicitamos su colaboración para el cumplimiento de las fechas.


Cualquier duda o comentario quedamos a sus órdenes,

Atentamente,

Contraloría de Clubes -  Valente Martínez Vivas (ext – 2826)
Contraloría de Inmobiliarias, Administradoras, IFM e ISP – Adriana Valencia Flores (ext – 2838)
Contraloría de Tiendas, Grupo Marti y Proitaly  – Patricia Pluma Luna (ext – 2846)
','Como parte de la integración de la contraloría de tiendas y clubes les enviamos un calendario único para el cierre contable de enero 2016 ',4, 'active',1, 'images/noticias/.jpg', 'images/noticias/.jpg');
CALL sp_set_nota ( 'Caja de ahorro', '','¿Ya conoces todos los beneficios de la caja de ahorro?',3, 'active',1, 'images/noticias/.jpg', 'images/noticias/.jpg');
CALL sp_set_nota ( 'Compras con Tarjeta Corporativa y Compras de Equipo de Computo', 'Estimados Todos:

En las últimas semanas se ha detectado un uso de las tarjetas corporativas de forma inadecuada en diferentes áreas, así como la compra de licenciamiento de software y compra de hardware sin revisión y aval de la Dirección de TI Corporativa.

Por lo anterior se les recuerda que:
1.- El uso de las tarjetas corporativas es exclusivamente para gastos de viaje y representación. NO se pueden utilizar para comprar ningún tipo de activo, software, hardware o para gastos personales no autorizados. En caso de detectarse este mal uso se procederá de inmediato a la cancelación de la misma.
Cabe mencionar que en las próximas semanas serán revisadas las tarjetas asignadas y en su caso serán migradas a las administradoras para que dichos gastos puedan ser deducibles.

2.- No están autorizado ninguna compra de Software o Hardware que no tenga el visto bueno y aprobación de la Dirección de TI. Existe un área especializada en dicha área que los puede apoyar en la compra de cualquier equipo y análisis de software que se requiera. En caso de detectar compras de este tipo no serán procesadas a pago o reembolsadas.

Les agradezco de antemano su atención y con mucho gusto podemos atender sus dudas al respecto de manera puntual.

Enrique Villalpando
Dirección de Contraloría Corporativa
Grupo Marti
','
En las últimas semanas se ha detectado un uso de las tarjetas corporativas de forma inadecuada en diferentes áreas, así como la compra de licenciamiento de software y compra de hardware sin revisión y aval de la Dirección de TI Corporativa.',3, 'active',1, 'images/noticias/.jpg', 'images/noticias/.jpg');
CALL sp_set_nota ( 'Entrega de premios foáneos ', 'Lleva imagen ','La entrega de premios foraneos se estará realizando del 14 al 31 de enero m                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ',3, 'active',1, 'images/noticias/.jpg', 'images/noticias/.jpg');



CALL sp_get_search_notice ('', 0, 'active', 10, 0);


select * from notices WHERE id = 2;

UPDATE notices SET urlImageMain = 'images/noticias/frio.jpg' , urlImageDetail= 'images/noticias/frio.jpg' WHERE id = 2;