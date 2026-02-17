-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Fev-2026 às 15:55
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `shi`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_birthdaysupdate_save` (IN `pid_birthday` INT, IN `pdate_birthday` DATE, IN `pname_birthday` VARCHAR(64), IN `pesp_birthday` VARCHAR(264), IN `pdepartment` VARCHAR(264), IN `pbirthday_active` TINYINT)   BEGIN
    -- A tabela correta é 'tb_birthdays', não 'tb_dbirthdays'
    -- A coluna correta é 'name_birthday', não 'name_birthdayr'
    -- A coluna correta é 'birthday_active', não 'dbirthday_active'
    
    -- Não é necessário declarar 'vid_birthday' se você não for usar.
    
	UPDATE tb_birthdays
    SET
		date_birthday = pdate_birthday,
		name_birthday = pname_birthday,
        esp_birthday = pesp_birthday,
        department = pdepartment,
        birthday_active = pbirthday_active
        
	WHERE id_birthday = pid_birthday;
    
    SELECT * FROM tb_birthdays WHERE id_birthday = pid_birthday;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_birthdays_save` (`pdate_birthday` VARCHAR(264), `pname_birthday` VARCHAR(264), `pesp_birthday` VARCHAR(264), `pdepartment` VARCHAR(264), `pbirthday_active` TINYINT(4))   BEGIN
    
    DECLARE vid_birthday INT;
    
    INSERT INTO tb_birthdays (id_birthday, date_birthday, name_birthday, esp_birthday, department, birthday_active)
    VALUES(vid_birthday, pdate_birthday, pname_birthday, pesp_birthday, pdepartment, pbirthday_active);
    
    SET vid_birthday = LAST_INSERT_ID();
    
    SELECT * FROM tb_birthdays WHERE id_birthday = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_class_occsupdate_save` (`pid_class_occ` INT, `pname` VARCHAR(64), `pdays_class_occ` VARCHAR(4), `pdescrition` MEDIUMTEXT, `pcod_class_occ` VARCHAR(64))   BEGIN
	
    DECLARE vid_class_occ INT;
    
    SELECT id_class_occ INTO vid_class_occ
    FROM tb_class_occs
    WHERE id_class_occ = pid_class_occ;
    
	UPDATE tb_class_occs
    SET
		name = pname,
		cod_class_occ = pcod_class_occ,
        days_class_occ = pdays_class_occ,
        descrition= pdescrition
    

	WHERE id_class_occ = pid_class_occ;
    
    SELECT * FROM tb_class_occs WHERE id_occlass_occ = pid_class_occ;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_class_occs_save` (`pname` VARCHAR(255), `pdays_class_occ` VARCHAR(4), `pdescrition` MEDIUMTEXT, `pcod_class_occ` VARCHAR(64))   BEGIN
    
    DECLARE vid_class_occ INT;
    
    INSERT INTO tb_class_occs (id_class_occ, name,  days_class_occ, descrition, cod_class_occ)
    VALUES(vid_class_occ, pname,  pdays_class_occ, pdescrition, pcod_class_occ);
    
    SET vid_class_occ = LAST_INSERT_ID();
    
    SELECT * FROM tb_class_occs WHERE id_class_occ = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_conclusionsupdate_save` (`pid_conclusion` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_conclusion` VARCHAR(64))   BEGIN
	
    DECLARE vid_conclusion INT;
    
    SELECT id_conclusion INTO vid_conclusion
    FROM tb_conclusions
    WHERE id_conclusion = pid_conclusion;
    
	UPDATE tb_conclusions
    SET
		name = pname,
        descrition =pdescrition,
		cod_conclusions = pcod_conclusion
    

	WHERE id_conclusion = pid_conclusion;
    
    SELECT * FROM tb_conclusions WHERE id_conclusion = pid_conclusion;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_conclusions_delete` (`pid_conclusion` INT)   BEGIN
    
    DECLARE vid_conclusion INT;
    
    SELECT id_conclusion INTO vid_conclusion
    FROM tb_conclusions
    WHERE id_conclusion = pid_conclusion;
    
    DELETE FROM tb_conclusions WHERE id_conclusion= pid_conclusion;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_conclusions_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_conclusion` VARCHAR(64))   BEGIN
    
    DECLARE vid_conclusion INT;
    
    INSERT INTO tb_conclusions (id_conclusion, name,  descrition, cod_conclusion)
    VALUES(vid_conclusion, pname, pdescrition, pcod_conclusion);
    
    SET vid_conclusion = LAST_INSERT_ID();
    
    SELECT * FROM tb_conclusions WHERE id_conclusion = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convenantsupdate_save` (IN `pid_convenant` INT, IN `pname_convenant` VARCHAR(264), IN `pcall_center` VARCHAR(264), IN `psite` VARCHAR(264), IN `pid_user` INT)   BEGIN

	DECLARE vid_convenant INT;
  
	SELECT id_convenant INTO vid_convenant 
	FROM tb_convenants 
	WHERE id_convenant = pid_convenant;
  
	UPDATE tb_convenants 
	SET 
		name_convenant = pname_convenant,
		call_center = pcall_center,
		site = psite,
		id_user = pid_user
		
	WHERE id_convenant = pid_convenant;
	
	SELECT * FROM tb_convenants WHERE id_convenant = pid_convenant;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_convenants_save` (IN `pid_convenant` INT, IN `pname_convenant` VARCHAR(264), IN `pcall_center` VARCHAR(60), IN `psite` VARCHAR(264), IN `pid_user` INT)   BEGIN
	
	IF pid_convenant > 0 THEN
	
		UPDATE tb_convenants
		SET
			name_convenant = pname_convenant,
			call_center = pcall_center,
			site = psite,
			id_user = pid_user
			
		WHERE id_convenant = pid_convenant;
		
	ELSE
	
		INSERT INTO tb_convenants ( id_convenant, name_convenant, call_center, site, id_user )
		VALUES ( pid_convenant, pname_convenant, pcall_center, psite, pid_user );
		
		SET pid_convenant = LAST_INSERT_ID();
		
	END IF;
	
	SELECT * FROM tb_convenants WHERE id_convenant = id_convenant;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_degree_damgsupdate_save` (`pid_degree_damg` INT, `pname` VARCHAR(64), `pdays_degree_damg` VARCHAR(4), `pdescrition` MEDIUMTEXT, `pcod_degree_damg` VARCHAR(64))   BEGIN
	
    DECLARE vid_degree_damg INT;
    
    SELECT id_degree_damg INTO vid_degree_damg
    FROM tb_degree_damgs
    WHERE id_degree_damg = pid_degree_damg;
    
	UPDATE tb_degree_damgs
    SET
		name = pname,
		cod_degree_damg = pcod_degree_damg,
        days_degree_damg = pdays_degree_damg,
        descrition = pdescrition
    

	WHERE id_degree_damg = pid_degree_damg;
    
    SELECT * FROM tb_degree_damgs WHERE id_degree_damg = pid_degree_damg;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_degree_damgs_delete` (`pid_degree_damg` INT)   BEGIN
    
    DECLARE vid_degree_damg INT;
    
    SELECT id_degree_damg INTO vid_degree_damg
    FROM tb_degree_damgs
    WHERE id_degree_damg = pid_degree_damg;
    
    DELETE FROM tb_degree_damgs WHERE id_degree_damg = pid_degree_damg;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_degree_damgs_save` (`pname` VARCHAR(255), `pdays_degree_damg` VARCHAR(4), `pdescrition` MEDIUMTEXT, `pcod_degree_damg` VARCHAR(64))   BEGIN
    
    DECLARE vid_degree_damg INT;
    
    INSERT INTO tb_degree_damgs (id_degree_damg, name,  days_degree_damg, descrition, cod_degree_damg)
    VALUES(vid_degree_damg, pname,  pdays_degree_damg, pdescrition, pcod_degree_damg);
    
    SET vid_degree_damg = LAST_INSERT_ID();
    
    SELECT * FROM tb_degree_damgs WHERE id_degree_damg = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_departmentsupdate_save` (`pid_department` INT, `pname` VARCHAR(64), `pcod_department` VARCHAR(64))   BEGIN
	
    DECLARE vid_department INT;
    
    SELECT id_department INTO vid_department
    FROM tb_departments
    WHERE id_department = pid_department;
    
	UPDATE tb_departments
    SET
		name = pname,
		cod_department = pcod_department
    

	WHERE id_department = pid_department;
    
    SELECT * FROM tb_departments WHERE id_department = pid_department;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_departments_delete` (`pid_department` INT)   BEGIN
    
    DECLARE vid_department INT;
    
    SELECT id_department INTO vid_department
    FROM tb_departments
    WHERE id_department = pid_department;
    
    DELETE FROM tb_departments WHERE id_department = pid_department;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_departments_save` (`pname` VARCHAR(255), `pcod_department` VARCHAR(64))   BEGIN
    
    DECLARE vid_department INT;
    
    INSERT INTO tb_departments (id_department, name, cod_department)
    VALUES(vid_department, pname, pcod_department);
    
    SET vid_department = LAST_INSERT_ID();
    
    SELECT * FROM tb_departments WHERE id_department = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_doctorsupdate_save` (IN `pid_doctor` INT, IN `pcrm_doctor` VARCHAR(128), IN `pname_doctor` VARCHAR(64), IN `pesp_doctor` VARCHAR(264), IN `pdepartment` VARCHAR(264), IN `pdoctor_active` TINYINT)   BEGIN
	
    DECLARE vid_doctor INT;
    
    SELECT id_doctor INTO vid_doctor
    FROM tb_doctors
    WHERE id_doctor = pid_doctor;
    
	UPDATE tb_doctors
    SET
		crm_doctor = pcrm_doctor,
		name_doctor = pname_doctor,
        esp_doctor = pesp_doctor,
        department = pdepartment,
        doctor_active = pdoctor_active
        
	WHERE id_doctor = pid_doctor;
    
    SELECT * FROM tb_doctors WHERE id_doctor = pid_doctor;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_doctors_save` (`pcrm_doctor` VARCHAR(264), `pname_doctor` VARCHAR(264), `pesp_doctor` VARCHAR(264), `pdepartment` VARCHAR(264), `pdoctor_active` TINYINT(4))   BEGIN
    
    DECLARE vid_doctor INT;
    
    INSERT INTO tb_doctors (id_doctor, crm_doctor, name_doctor, esp_doctor, department, doctor_active)
    VALUES(vid_doctor, pcrm_doctor, pname_doctor, pesp_doctor, pdepartment, pdoctor_active);
    
    SET vid_doctor = LAST_INSERT_ID();
    
    SELECT * FROM tb_doctors WHERE id_doctor = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eventsupdate_save` (IN `pid_event` INT, IN `pname_event` VARCHAR(264), IN `pdescription_event` TEXT, IN `url_slug` VARCHAR(264), IN `pid_user` INT)   BEGIN

	IF pid_event > 0 THEN
		
		UPDATE tb_events
			SET 
			name_event = pname_event,
			description_event = pdescription_event,
            url_slug = url_slug,
			id_user = pid_user
            
        WHERE id_event = pid_event;
        
    ELSE
		
		INSERT INTO tb_events (id_event, name_event, description_event, url_slug, id_user) 
        VALUES(pid_event, pname_event, pdescription_event, url_slug, pid_user);
        
        SET pid_event = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_events WHERE id_event = pid_event;
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_events_save` (IN `pid_event` INT, IN `pname_event` VARCHAR(264), IN `pdescription_event` TEXT, IN `url_slug` VARCHAR(264), IN `pid_user` INT)   BEGIN

	IF pid_event > 0 THEN
		
		UPDATE tb_events
			SET 
			name_event = pname_event,
			description_event = pdescription_event,
            url_slug = url_slug,
			id_user = pid_user
            
        WHERE id_event = pid_event;
        
    ELSE
		
		INSERT INTO tb_events (id_event, name_event, description_event, url_slug, id_user) 
        VALUES(pid_event, pname_event, pdescription_event, url_slug, pid_user);
        
        SET pid_event = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_events WHERE id_event = pid_event;
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_factoccurredsupdate_save` (`pid_factoccurred` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_factoccurred` VARCHAR(64))   BEGIN
	
    DECLARE vid_factoccurred INT;
    
    SELECT id_factoccurred INTO vid_factoccurred
    FROM tb_factoccurreds
    WHERE id_factoccurred = pid_factoccurred;
    
	UPDATE tb_factoccurreds
    SET
		name = pname,
        descrition =pdescrition,
		cod_factoccurred = pcod_factoccurred
    

	WHERE id_factoccurred = pid_factoccurred;
    
    SELECT * FROM tb_factoccurreds WHERE id_factoccurred = pid_factoccurred;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_factoccurreds_delete` (`pid_factoccurred` INT)   BEGIN
    
    DECLARE vid_factoccurred INT;
    
    SELECT id_factoccurred INTO vid_factoccurred
    FROM tb_factoccurreds
    WHERE id_factoccurred= pid_factoccurred;
    
    DELETE FROM tb_factoccurreds WHERE id_factoccurred = pid_factoccurred;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_factoccurreds_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_factoccurred` VARCHAR(64))   BEGIN
    
    DECLARE vid_factoccurred INT;
    
    INSERT INTO tb_factoccurreds (id_factoccurred, name,  descrition, cod_factoccurred)
    VALUES(vid_factoccurred, pname, pdescrition, pcod_factoccurred);
    
    SET vid_factoccurred = LAST_INSERT_ID();
    
    SELECT * FROM tb_factoccurreds WHERE id_factoccurred = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incidentsupdate_save` (`pid_incident` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_incident` VARCHAR(64))   BEGIN
	
    DECLARE vid_incident INT;
    
    SELECT id_incident INTO vid_incident
    FROM tb_incidents
    WHERE id_incident = pid_incident;
    
	UPDATE tb_incidents
    SET
		name = pname,
        descrition =pdescrition,
		cod_incident = pcod_incident
    

	WHERE id_incident = pid_incident;
    
    SELECT * FROM tb_incidents WHERE id_incident = pid_incident;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incidents_delete` (`pid_incident` INT)   BEGIN
    
    DECLARE vid_incident INT;
    
    SELECT id_incident INTO vid_incident
    FROM tb_incidents
    WHERE id_incident = pid_incident;
    
    DELETE FROM tb_incidents WHERE id_incident = pid_incident;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incidents_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_incident` VARCHAR(64))   BEGIN
    
    DECLARE vid_incident INT;
    
    INSERT INTO tb_incidents (id_incident, name,  descrition, cod_incident)
    VALUES(vid_incident, pname, pdescrition, pcod_incident);
    
    SET vid_incident = LAST_INSERT_ID();
    
    SELECT * FROM tb_incidents WHERE id_incident = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_internacionalsecuritysupdate_save` (`pid_internacionalsecurity` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_internacionalsecurity` VARCHAR(64))   BEGIN
	
    DECLARE vid_internacionalsecurity INT;
    
    SELECT id_internacionalsecurity INTO vid_internacionalsecurity
    FROM tb_internacionalsecuritys
    WHERE id_internacionalsecurity = pid_internacionalsecurity;
    
	UPDATE tb_internacionalsecuritys
    SET
		name = pname,
        descrition =pdescrition,
		cod_internacionalsecurity = pcod_internacionalsecurity
    

	WHERE id_internacionalsecurity = pid_internacionalsecurity;
    
    SELECT * FROM tb_internacionalsecuritys WHERE id_internacionalsecurity = pid_internacionalsecurity;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_internacionalsecuritys_delete` (`pid_internacionalsecurity` INT)   BEGIN
    
    DECLARE vid_internacionalsecurity INT;
    
    SELECT id_internacionalsecurity INTO vid_internacionalsecurity
    FROM tb_internacionalsecuritys
    WHERE id_internacionalsecurity = pid_internacionalsecurity;
    
    DELETE FROM tb_internacionalsecuritys WHERE id_internacionalsecurity = pid_internacionalsecurity;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_internacionalsecuritys_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_internacionalsecurity` VARCHAR(64))   BEGIN
    
    DECLARE vid_internacionalsecurity INT;
    
    INSERT INTO tb_internacionalsecuritys (id_internacionalsecurity, name,  descrition, cod_internacionalsecurity)
    VALUES(vid_internacionalsecurity, pname, pdescrition, pcod_internacionalsecurity);
    
    SET vid_internacionalsecurity = LAST_INSERT_ID();
    
    SELECT * FROM tb_internacionalsecuritys WHERE id_internacionalsecurity = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_multiplenotification_save` (IN `pid_notificacao` INT(11), IN `pdt_notificacao` DATE, IN `ppatient` VARCHAR(3), IN `pnome_pac` VARCHAR(100), IN `pdt_nasc` DATE, IN `patendimento` VARCHAR(45), IN `pregistro` INT(10), IN `pdt_internamento` DATE, IN `pdt_oco` DATE, IN `phr_oco` VARCHAR(10), IN `pst_cante` VARCHAR(100), IN `pst_cado` VARCHAR(100), IN `pclass_incident` VARCHAR(100), IN `pdescricao` MEDIUMTEXT, IN `pclass_occ` VARCHAR(100), IN `pdegree_damg` VARCHAR(100), IN `psolution` MEDIUMTEXT, IN `ppatientsecurity` VARCHAR(100), IN `pqclass_incident` VARCHAR(100), IN `pqclass_occ` VARCHAR(100), IN `pqdegree_damg` VARCHAR(100), IN `preturn_date` TEXT, IN `pprocess` VARCHAR(45), IN `pproblem` VARCHAR(45), IN `pfact_occurred` VARCHAR(45), IN `pvalidation_date` TEXT, IN `pproposed_action` MEDIUMTEXT, IN `peventinvestigation` VARCHAR(3), IN `pinternacionalsecurity` VARCHAR(100), IN `pconclusion` VARCHAR(45))   BEGIN
    DECLARE vid_notificacao_without_year INT;
    DECLARE vid_notificacao VARCHAR(100);
    DECLARE vano CHAR(2);

    SET vano = RIGHT(YEAR(CURDATE()), 2);
    IF vano = RIGHT((SELECT MAX(id_notificacao) FROM tb_notificacao), 2) THEN
        SELECT MAX(id_notificacao_without_year) + 1 INTO vid_notificacao_without_year FROM tb_notificacao;
    ELSE
        SET vid_notificacao_without_year = 1;
    END IF;
    SET vid_notificacao = CONCAT(vid_notificacao_without_year, vano);
    INSERT INTO tb_notificacao (id_notificacao, id_notificacao_without_year, dt_notificacao, patient, nome_pac, dt_nasc, atendimento, registro, dt_internamento, dt_oco, hr_oco, st_cante, st_cado, class_incident, descricao, class_occ, degree_damg, solution, patientsecurity, qclass_incident, qclass_occ, qdegree_damg, return_date, process, problem, fact_occurred, validation_date, proposed_action, eventinvestigation, internacionalsecurity, conclusion)
    VALUES (vid_notificacao, vid_notificacao_without_year, pdt_notificacao, ppatient, pnome_pac, pdt_nasc, patendimento, pregistro, pdt_internamento, pdt_oco, phr_oco, pst_cante, pst_cado, pclass_incident, pdescricao, pclass_occ, pdegree_damg, psolution, ppatientsecurity, pqclass_incident, pqclass_occ, pqdegree_damg, preturn_date, pprocess, pproblem, pfact_occurred, pvalidation_date, pproposed_action, peventinvestigation, pinternacionalsecurity, pconclusion);
 
    SELECT * FROM tb_notificacao WHERE id_notificacao = vid_notificacao;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_notification_save` (IN `pid_notificacao` INT(11), IN `pdt_notificacao` DATE, IN `ppatient` VARCHAR(3), IN `pnome_pac` VARCHAR(100), IN `pdt_nasc` DATE, IN `patendimento` VARCHAR(45), IN `pregistro` INT(10), IN `pdt_internamento` DATE, IN `pdt_oco` DATE, IN `phr_oco` VARCHAR(10), IN `pst_cante` VARCHAR(100), IN `pst_cado` VARCHAR(100), IN `pclass_incident` VARCHAR(100), IN `pdescricao` MEDIUMTEXT, IN `pclass_occ` VARCHAR(100), IN `pdegree_damg` VARCHAR(100), IN `psolution` MEDIUMTEXT)   BEGIN
    DECLARE vid_notificacao_without_year INT;
    DECLARE vid_notificacao VARCHAR(10);
    DECLARE vano CHAR(2);

    SET vano = RIGHT(YEAR(CURDATE()), 2);
    IF vano = RIGHT((SELECT MAX(id_notificacao) FROM tb_notificacao), 2) THEN
        SELECT MAX(id_notificacao_without_year) + 1 INTO vid_notificacao_without_year FROM tb_notificacao;
    ELSE
        SET vid_notificacao_without_year = 1;
    END IF;
    SET vid_notificacao = CONCAT(vid_notificacao_without_year, vano);
    INSERT INTO tb_notificacao (id_notificacao, id_notificacao_without_year, dt_notificacao, patient, nome_pac, dt_nasc, atendimento, registro, dt_internamento, dt_oco, hr_oco, st_cante, st_cado, class_incident, descricao, class_occ, degree_damg, solution)
    VALUES (vid_notificacao, vid_notificacao_without_year, pdt_notificacao, ppatient, pnome_pac, pdt_nasc, patendimento, pregistro, pdt_internamento, pdt_oco, phr_oco, pst_cante, pst_cado, pclass_incident, pdescricao, pclass_occ, pdegree_damg, psolution);
 
    SELECT * FROM tb_notificacao WHERE id_notificacao = vid_notificacao;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_notification_saveadmin` (IN `pid_notificacao` INT(11), IN `pdt_notificacao` DATE, IN `ppatient` VARCHAR(3), IN `pnome_pac` VARCHAR(100), IN `pdt_nasc` VARCHAR(10), IN `patendimento` VARCHAR(45), IN `pregistro` INT(10), IN `pdt_internamento` DATE, IN `pdt_oco` DATE, IN `phr_oco` VARCHAR(10), IN `pst_cante` VARCHAR(100), IN `pst_cado` VARCHAR(100), IN `pclass_incident` VARCHAR(100), IN `pdescricao` MEDIUMTEXT, IN `pclass_occ` VARCHAR(100), IN `pdegree_damg` VARCHAR(100), IN `psolution` MEDIUMTEXT)   BEGIN
    DECLARE vid_notificacao_without_year INT;
    DECLARE vid_notificacao VARCHAR(10);
    DECLARE vano CHAR(2);

    SET vano = RIGHT(YEAR(CURDATE()), 2);
    IF vano = RIGHT((SELECT MAX(id_notificacao) FROM tb_notificacao), 2) THEN
        SELECT MAX(id_notificacao_without_year) + 1 INTO vid_notificacao_without_year FROM tb_notificacao;
    ELSE
        SET vid_notificacao_without_year = 1;
    END IF;
    SET vid_notificacao = CONCAT(vid_notificacao_without_year, vano);
    INSERT INTO tb_notificacao (id_notificacao, id_notificacao_without_year, dt_notificacao, patient, nome_pac, dt_nasc, atendimento, registro, dt_internamento, dt_oco, hr_oco, st_cante, st_cado, class_incident, descricao, class_occ, degree_damg, solution)
    VALUES (vid_notificacao, vid_notificacao_without_year, pdt_notificacao, ppatient, pnome_pac, pdt_nasc, patendimento, pregistro, pdt_internamento,pdt_oco, phr_oco, pst_cante, pst_cado, pclass_incident, pdescricao, pclass_occ, pdegree_damg, psolution);
 
    SELECT * FROM tb_notificacao WHERE id_notificacao = vid_notificacao;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_notification_save_old` (IN `pnome_pac` VARCHAR(100), IN `pdt_nasc` VARCHAR(10), IN `pregistro` INT(10), IN `pdt_relato` DATETIME, IN `pdt_oco` DATETIME, IN `pst_cante` VARCHAR(100), IN `pst_cado` VARCHAR(100), IN `pdescricao` TEXT, IN `psolution` TEXT)   BEGIN
	
    DECLARE vid_notificacao INT;
    
	INSERT INTO tb_notificacao (id_notificacao, nome_pac, dt_nasc, registro, dt_relato, dt_oco, st_cante, st_cado, descricao, solution)
    VALUES(vid_notificacao, pnome_pac, pdt_nasc, pregistro, pdt_relato, pdt_oco, pst_cante, pst_cado, pdescricao, psolution);
    
    SET vid_notificacao = LAST_INSERT_ID();
    
    SELECT * FROM tb_notificacao WHERE id_notificacao = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_notification_update` (IN `pid_notificacao` INT(11), IN `ppatient` VARCHAR(3), IN `pnome_pac` VARCHAR(100), IN `pdt_nasc` DATE, IN `patendimento` VARCHAR(45), IN `pregistro` INT(10), IN `pdt_internamento` DATE, IN `pdt_oco` DATE, IN `phr_oco` VARCHAR(10), IN `pst_cante` VARCHAR(100), IN `pst_cado` VARCHAR(100), IN `pclass_incident` VARCHAR(100), IN `pdescricao` MEDIUMTEXT, IN `pclass_occ` VARCHAR(100), IN `pdegree_damg` VARCHAR(100), IN `psolution` MEDIUMTEXT, IN `ppatientsecurity` VARCHAR(100), IN `pqclass_incident` VARCHAR(100), IN `pqclass_occ` VARCHAR(100), IN `pqdegree_damg` VARCHAR(100), IN `preturn_date` TEXT, IN `pprocess` VARCHAR(45), IN `pproblem` VARCHAR(45), IN `pfact_occurred` VARCHAR(45), IN `pvalidation_date` TEXT, IN `pproposed_action` MEDIUMTEXT, IN `peventinvestigation` VARCHAR(3), IN `pinternacionalsecurity` VARCHAR(100), IN `pconclusion` VARCHAR(45))   BEGIN
	IF pid_notificacao > 0 THEN
		UPDATE tb_notificacao
			SET 
			
            patient = ppatient,
			nome_pac = pnome_pac,
			dt_nasc = pdt_nasc,
            atendimento = patendimento,
			registro = pregistro, 
			dt_internamento = pdt_internamento,
			dt_oco = pdt_oco,
			hr_oco = phr_oco, 
			st_cante = pst_cante, 
			st_cado = pst_cado, 
			class_incident = pclass_incident, 
			descricao = pdescricao, 
			class_occ = pclass_occ, 
			degree_damg = pdegree_damg, 
			solution = psolution, 
			patientsecurity = ppatientsecurity, 
            qclass_incident = pqclass_incident, 
            qclass_occ = pqclass_occ,
			qdegree_damg= pqdegree_damg,
			return_date = preturn_date, 
			process = pprocess, 
			problem = pproblem, 
			fact_occurred = pfact_occurred,  
			validation_date = pvalidation_date, 
			proposed_action = pproposed_action, 
            eventinvestigation = peventinvestigation,
			internacionalsecurity = pinternacionalsecurity,
			conclusion = pconclusion
        WHERE id_notificacao = pid_notificacao;
    ELSE
			INSERT INTO tb_notificacao (id_notificacao,  patient, nome_pac, dt_nasc, atendimento, registro, dt_internamento, dt_oco, hr_oco, st_cante, st_cado, descricao, class_occ, degree_damg, solution, patientsecurity, qclass_incident, qclass_occ, degree_damg, return_date, process, problem, fact_occurred, validation_date, proposed_action, eventinvestigation, internacionalsecurity, conclusion)
    VALUES(vid_notificacao, ppatient, pnome_pac, pdt_nasc, patendimento, pregistro, pdt_internamento, pdt_oco, phr_oco, pst_cante, pst_cado, pdescricao, pclass_occ, pdegree_damg, psolution, ppatientsecurity, pqclass_incident,  pqclass_occ, pdegree_damg, preturn_date, pprocess, pproblem, pfact_occurred, pvalidation_date, pproposed_action, peventinvestigation, pinternacionalsecurity, pconclusion);
        SET pid_notificacao = LAST_INSERT_ID();
    END IF;
    SELECT * FROM tb_notificacao WHERE id_notificacao = pid_notificacao;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_occurrencesupdate_save` (`pid_occurrence` INT, `pname` VARCHAR(64), `pdays_occurrence` VARCHAR(6), `pdescrition` MEDIUMTEXT, `pcod_occurrence` VARCHAR(64))   BEGIN
	
    DECLARE vid_occurrence INT;
    
    SELECT id_occurrence INTO vid_occurrence
    FROM tb_occurrences
    WHERE id_occurrence = pid_occurrence;
    
	UPDATE tb_occurrences
    SET
		name = pname,
		cod_occurrence = pcod_occurrence,
        days_occurrence = pdays_occurrence,
        descrition= pdescrition
    

	WHERE id_occurrence = pid_occurrence;
    
    SELECT * FROM tb_occurrences WHERE id_occurrence = pid_occurrence;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_occurrences_delete` (`pid_occurrence` INT)   BEGIN
    
    DECLARE vid_occurrence INT;
    
    SELECT id_occurrence INTO vid_occurrence
    FROM tb_occurrences
    WHERE id_occurrence = pid_occurrence;
    
    DELETE FROM tb_occurrences WHERE id_occurrence = pid_occurrence;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_occurrences_save` (`pname` VARCHAR(255), `pdays_occurrence` VARCHAR(6), `pdescrition` MEDIUMTEXT, `pcod_occurrence` VARCHAR(64))   BEGIN
    
    DECLARE vid_occurrence INT;
    
    INSERT INTO tb_occurrences (id_occurrence, name, days_occurrence, descrition, cod_occurrence)
    VALUES(vid_occurrence, pname,  pdays_occurrence, pdescrition, pcod_occurrence);
    
    SET vid_occurrence = LAST_INSERT_ID();
    
    SELECT * FROM tb_occurrences WHERE id_occurrence = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_patientsecuritysupdate_save` (`pid_patientsecurity` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_patientsecurity` VARCHAR(64))   BEGIN
	
    DECLARE vid_patientsecurity INT;
    
    SELECT id_patientsecurity INTO vid_patientsecurity
    FROM tb_patientsecuritys
    WHERE id_patientsecurity = pid_patientsecurity;
    
	UPDATE tb_patientsecuritys
    SET
		name = pname,
        descrition =pdescrition,
		cod_patientsecurity = pcod_patientsecurity
    

	WHERE id_patientsecurity= pid_patientsecurity;
    
    SELECT * FROM tb_patientsecuritys WHERE id_patientsecurity = pid_patientsecurity;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_patientsecuritys_delete` (`pid_patientsecurity` INT)   BEGIN
    
    DECLARE vid_patientsecurity INT;
    
    SELECT id_patientsecurity INTO vid_patientsecurity
    FROM tb_patientsecuritys
    WHERE id_patientsecurity = pid_patientsecurity;
    
    DELETE FROM tb_patientsecuritys WHERE id_patientsecurity = pid_patientsecurity;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_patientsecuritys_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_patientsecurity` VARCHAR(64))   BEGIN
    
    DECLARE vid_patientsecurity INT;
    
    INSERT INTO tb_patientsecuritys (id_patientsecurity, name,  descrition, cod_patientsecurity)
    VALUES(vid_patientsecurity, pname, pdescrition, pcod_patientsecurity);
    
    SET vid_patientsecurity = LAST_INSERT_ID();
    
    SELECT * FROM tb_patientsecuritys WHERE id_patientsecurity = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_popupsupdate_save` (`pid_popup` INT(11), `ppopup_title` VARCHAR(264), `ppopup_active` TINYINT(4), `pid_user` INT(11))   BEGIN
	
    DECLARE vid_popup INT;
    
    SELECT id_popup INTO vid_popup
    FROM tb_popups
    WHERE id_popup = vid_popup;
    
	UPDATE tb_popups
    SET
		popup_title = ppopup_title,
		popup_active = ppopup_active,
		id_user = pid_user
        
	WHERE id_popup = pid_popup;
    
    SELECT * FROM tb_popups WHERE id_popup = pid_popup;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_popups_save` (`pid_popup` INT(11), `ppopup_title` VARCHAR(264), `ppopup_active` TINYINT(4), `pid_user` INT(11))   BEGIN
	
	IF pid_popup > 0 THEN
		
		UPDATE tb_popups
        SET 
			popup_title = ppopup_title,
			popup_active = ppopup_active,
			id_user = pid_user
            
        WHERE id_popup = pid_popup;
        
    ELSE
		
		INSERT INTO tb_popups (id_popup, popup_title, popup_active, id_user) 
        VALUES(pid_popup, ppopup_title, ppopup_active, pid_user);
        
        SET pid_popup = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_popups WHERE id_popup = pid_popup;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_postsupdate_save` (IN `pid_post` INT(11), IN `ptitulo` VARCHAR(264), IN `pautor` TEXT, IN `ptexto` TEXT, IN `url_slug` VARCHAR(264), `ppost_active` TINYINT(4), IN `pid_user` INT(11))   BEGIN

	IF pid_post > 0 THEN
		
		UPDATE tb_posts
			SET 
            id_post = pid_post,
			titulo = ptitulo,
			autor = pautor,
            texto = ptexto,
            url_slug = url_slug,
            post_active = ppost_active,
			id_user = pid_user
            
        WHERE id_post = pid_post;
        
    ELSE
		
		INSERT INTO tb_posts (id_post, titulo, autor, texto, url_slug, post_active, id_user) 
        VALUES(pid_post, ptitulo, pautor, ptexto, url_slug, ppost_active, pid_user);
        
        SET pid_post = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_posts WHERE id_post = pid_post;
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_posts_save` (`ptitulo` VARCHAR(264), `pautor` VARCHAR(64), `ptexto` TEXT, IN `url_slug` VARCHAR(264), `ppost_active` TINYINT(4), `pid_user` INT(11))   BEGIN

    DECLARE vid_post INT;
		
		INSERT INTO tb_posts (id_post, titulo, autor, texto, url_slug, post_active, id_user) 
        VALUES(vid_post, ptitulo, pautor, ptexto, url_slug, ppost_active, pid_user);
        
        SET vid_post = LAST_INSERT_ID();
        
    
    SELECT * FROM tb_posts WHERE id_post = LAST_INSERT_ID();
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_problemsupdate_save` (`pid_problem` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_problem` VARCHAR(64))   BEGIN
	
    DECLARE vid_problem INT;
    
    SELECT id_problem INTO vid_problem
    FROM tb_problems
    WHERE id_problem = pid_problem;
    
	UPDATE tb_problems
    SET
		name = pname,
        descrition =pdescrition,
		cod_problems = pcod_problem
    

	WHERE id_problem= pid_problem;
    
    SELECT * FROM tb_problems WHERE id_problem = pid_problem;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_problems_delete` (`pid_problem` INT)   BEGIN
    
    DECLARE vid_problem INT;
    
    SELECT id_problem INTO vid_problem
    FROM tb_problems
    WHERE id_problem = pid_problem;
    
    DELETE FROM tb_problems WHERE id_problem= pid_problem;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_problems_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_problem` VARCHAR(64))   BEGIN
    
    DECLARE vid_problem INT;
    
    INSERT INTO tb_problems (id_problem, name,  descrition, cod_problem)
    VALUES(vid_problem, pname, pdescrition, pcod_problem);
    
    SET vid_problem = LAST_INSERT_ID();
    
    SELECT * FROM tb_problems WHERE id_problem = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_processsupdate_save` (`pid_process` INT, `pname` VARCHAR(64), `pdescrition` MEDIUMTEXT, `pcod_process` VARCHAR(64))   BEGIN
	
    DECLARE vid_process INT;
    
    SELECT id_process INTO vid_process
    FROM tb_processs
    WHERE id_process = pid_process;
    
	UPDATE tb_processs
    SET
		name = pname,
        descrition =pdescrition,
		cod_process = pcod_process
    

	WHERE id_process= pid_process;
    
    SELECT * FROM tb_processs WHERE id_process = pid_process;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_processs_delete` (`pid_process` INT)   BEGIN
    
    DECLARE vid_process INT;
    
    SELECT id_process INTO vid_process
    FROM tb_processs
    WHERE id_process = pid_process;
    
    DELETE FROM tb_processs WHERE id_process = pid_process;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_processs_save` (`pname` VARCHAR(255), `pdescrition` MEDIUMTEXT, `pcod_process` VARCHAR(64))   BEGIN
    
    DECLARE vid_process INT;
    
    INSERT INTO tb_processs (id_process, name,  descrition, cod_process)
    VALUES(vid_process, pname, pdescrition, pcod_process);
    
    SET vid_process = LAST_INSERT_ID();
    
    SELECT * FROM tb_processs WHERE id_process = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ramaisupdate_save` (IN `pid_agenda` INT, IN `punidade` VARCHAR(128), IN `psetor_sala` VARCHAR(128), IN `pcolaborador` VARCHAR(128), IN `pddr` VARCHAR(128), IN `pramal` INT(11), IN `pcelular` VARCHAR(128), IN `pemails` VARCHAR(128), IN `pativo` VARCHAR(2))   BEGIN
    UPDATE tb_ramais
    SET
        unidade = punidade,
        setor_sala = psetor_sala, -- Mapeando parâmetro correto para a coluna
        colaborador = pcolaborador,
        ddr = pddr,
        ramal = pramal,
        celular = pcelular,
        emails = pemails,
        ativo = pativo
    WHERE id_agenda = pid_agenda;
    
    SELECT * FROM tb_ramais WHERE id_agenda = pid_agenda;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ramais_delete` (`pid_agenda` INT)   BEGIN
    
    DECLARE vid_agenda INT;
    
    SELECT id_agenda INTO vid_agenda
    FROM tb_ramais
    WHERE id_agenda = pid_agenda;
    
    DELETE FROM tb_ramais WHERE id_agenda = pid_agenda;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ramais_save` (IN `punidade` VARCHAR(128), IN `psetor_sala` VARCHAR(128), IN `pcolaborador` VARCHAR(128), IN `pddr` VARCHAR(128), IN `pramal` INT(11), IN `pcelular` VARCHAR(128), IN `pemails` VARCHAR(128), IN `pativo` VARCHAR(2))   BEGIN
    -- 1. Inserimos usando os parâmetros (punidade, psetor_sala, etc.)
    -- Não incluímos o id_agenda se ele for AUTO_INCREMENT
    INSERT INTO tb_ramais (unidade, setor_sala, colaborador, ddr, ramal, celular, emails, ativo)
    VALUES (punidade, psetor_sala, pcolaborador, pddr, pramal, pcelular, pemails, pativo);
    
    -- 2. Retornamos o registro que acabou de ser criado usando o LAST_INSERT_ID()
    SELECT * FROM tb_ramais WHERE id_agenda = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_subscriptionsupdate_save` (IN `pid_subscription` INT(11), IN `pcod_subscription` VARCHAR(264), IN `pname` VARCHAR(50), IN `pname_color` VARCHAR(50), IN `pdescription` VARCHAR(264), IN `url_slug` VARCHAR(264), `psubscription_active` TINYINT(4), IN `pid_user` INT(11))   BEGIN

	IF pid_subscription > 0 THEN
		
		UPDATE tb_subscriptions
			SET 
            id_subscription = pid_subscription,
			cod_subscription = pcod_subscription,
			name = pname,
            name_color= pname_color,
            description= pdescription,
            url_slug = url_slug,
            subscription_active = psubscription_active,
			id_user = pid_user
            
        WHERE id_subscription = pid_subscription;
        
    ELSE
		
		INSERT INTO tb_subscriptions (id_subscription, cod_subscription, name, name_color, description, url_slug, subscription_active, id_user) 
        VALUES(pid_subscription, pcod_subscription, pname, pname_color, pdescription, url_slug, psubscription_active, pid_user);
        
        SET pid_subscription = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_subscriptions WHERE id_subscription = pid_subscription;
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_subscriptions_save` (`pcod_subscription` VARCHAR(264), `pname` VARCHAR(50), IN `pname_color` VARCHAR(50), IN `pdescription` VARCHAR(264), IN `url_slug` VARCHAR(264), `psubscription_active` TINYINT(4), `pid_user` INT(11))   BEGIN

    DECLARE vid_subscription INT;
		
		INSERT INTO tb_subscriptions (id_subscription, cod_subscription, name, name_color, description,  url_slug, subscription_active, id_user) 
        VALUES(vid_subscription, pcod_subscription, pname, pname_color, pdescription, url_slug, psubscription_active, pid_user);
        
        SET vid_subscription = LAST_INSERT_ID();
        
    
    SELECT * FROM tb_subscriptions WHERE id_subscription = LAST_INSERT_ID();
    

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_unitsupdate_save` (`pid_unit` INT, `pname` VARCHAR(64), `pcod_unit` VARCHAR(64))   BEGIN
	
    DECLARE vid_unit INT;
    
    SELECT id_unit INTO vid_unit
    FROM tb_units
    WHERE id_unit = pid_unit;
    
	UPDATE tb_units
    SET
		name = pname,
		cod_unit = pcod_unit
    

	WHERE id_unit = pid_unit;
    
    SELECT * FROM tb_units WHERE id_unit = pid_unit;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_units_delete` (`pid_unit` INT)   BEGIN
    
    DECLARE vid_unit INT;
    
    SELECT id_unit INTO vid_unit
    FROM tb_units
    WHERE id_unit = pid_unit;
    
    DELETE FROM tb_units WHERE id_unit = pid_unit;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_units_save` (`pname` VARCHAR(255), `pcod_unit` VARCHAR(64))   BEGIN
    
    DECLARE vid_unit INT;
    
    INSERT INTO tb_units (id_unit, name, cod_unit)
    VALUES(vid_unit, pname, pcod_unit);
    
    SET vid_unit = LAST_INSERT_ID();
    
    SELECT * FROM tb_units WHERE id_unit = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usersupdate_save` (`pid_user` INT, `pdesname` VARCHAR(128), `plogin` VARCHAR(64), `psenha` VARCHAR(264), `psetor` VARCHAR(64), `pinadmin` TINYINT(2), `puser_active` TINYINT(4))   BEGIN
	
    DECLARE vid_user INT;
    
    SELECT id_user INTO vid_user
    FROM tb_users
    WHERE id_user = pid_user;
    
	UPDATE tb_users
    SET
		id_user = pid_user,
		desname = pdesname,
		login = plogin,
        senha = psenha,
        setor = psetor,
        inadmin = pinadmin,
        user_active = puser_active
	WHERE id_user = pid_user;
    
    SELECT * FROM tb_users WHERE id_user = pid_user;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_delete` (`pid_user` INT)   BEGIN
    
    DECLARE vid_user INT;
    
    SET FOREIGN_KEY_CHECKS = 0;
    
    SELECT id_user INTO vid_user
    FROM tb_users
    WHERE id_user = pid_user;
    
    DELETE FROM tb_posts WHERE id_user = pid_user;
    DELETE FROM tb_users WHERE id_user = pid_user;
    
    SET FOREIGN_KEY_CHECKS = 1;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_save` (`pdesname` VARCHAR(128), `plogin` VARCHAR(64), `psenha` VARCHAR(264), `psetor` VARCHAR(64), `pinadmin` TINYINT, `puser_active` TINYINT(4))   BEGIN
	
    DECLARE vid_user INT;
    
	INSERT INTO tb_users (id_user, desname, login, senha, setor, inadmin, user_active)
    VALUES(vid_user,pdesname, plogin, psenha, psetor, pinadmin, puser_active);
    
    SET vid_user = LAST_INSERT_ID();
    
    SELECT * FROM tb_users WHERE id_user = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_alert`
--

CREATE TABLE `tb_alert` (
  `id` int(11) NOT NULL,
  `max_seqptm` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_alert`
--

INSERT INTO `tb_alert` (`id`, `max_seqptm`) VALUES
(1, '83288042');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_birthdays`
--

CREATE TABLE `tb_birthdays` (
  `id_birthday` int(11) NOT NULL,
  `date_birthday` date NOT NULL,
  `name_birthday` varchar(264) NOT NULL,
  `esp_birthday` varchar(264) NOT NULL,
  `birthday_active` tinyint(4) NOT NULL,
  `id_user` int(11) NOT NULL,
  `department` varchar(264) NOT NULL,
  `dt_birthday` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_birthdays`
--

INSERT INTO `tb_birthdays` (`id_birthday`, `date_birthday`, `name_birthday`, `esp_birthday`, `birthday_active`, `id_user`, `department`, `dt_birthday`) VALUES
(99, '2026-02-03', 'Parabenizando ao aniversariante(s)! Grande abraço da Shineray do Brasil !', 'Parabenizando ao aniversariante(s)! Grande abraço da Shineray do Brasil !', 1, 0, 'Geral', '2026-02-03 12:27:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_class_occs`
--

CREATE TABLE `tb_class_occs` (
  `id_class_occ` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_class_occ` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `days_class_occ` varchar(4) DEFAULT NULL,
  `descrition` mediumtext DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=2340 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_class_occs`
--

INSERT INTO `tb_class_occs` (`id_class_occ`, `name`, `cod_class_occ`, `created_at`, `days_class_occ`, `descrition`) VALUES
(1, 'Improcedente', '', '2021-07-17 19:36:00', NULL, NULL),
(2, 'Não Conformidade', '', '2021-07-17 19:36:00', NULL, NULL),
(3, 'Circustância de Risco', '', '2021-07-17 19:36:00', NULL, NULL),
(4, 'Near Miss', '', '2021-07-17 19:36:00', NULL, NULL),
(5, 'Incidente Sem Dano', '', '2021-07-17 19:36:00', NULL, NULL),
(6, 'Incidente Com Dano', '', '2021-07-17 19:36:00', NULL, NULL),
(7, 'Óbito', '', '2021-07-17 19:36:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_conclusions`
--

CREATE TABLE `tb_conclusions` (
  `id_conclusion` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_conclusion` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_conclusions`
--

INSERT INTO `tb_conclusions` (`id_conclusion`, `name`, `cod_conclusion`, `descrition`, `created_at`) VALUES
(1, 'Encerrada', '', '', '2024-04-12 12:21:01'),
(2, 'Mantida', '', '', '2024-04-12 12:21:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_convenants`
--

CREATE TABLE `tb_convenants` (
  `id_convenant` int(11) NOT NULL,
  `name_convenant` varchar(264) NOT NULL,
  `call_center` varchar(64) NOT NULL,
  `site` varchar(264) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_convenant` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabela de Convênios';

--
-- Extraindo dados da tabela `tb_convenants`
--

INSERT INTO `tb_convenants` (`id_convenant`, `name_convenant`, `call_center`, `site`, `id_user`, `dt_convenant`) VALUES
(1, 'Amil', '(81) 3004-1000 / 0800-706-2363', 'https://www.amil.com.br/', 1, '2019-06-18 16:20:48'),
(2, 'Bradesco', '(83) 98718-9754', 'https://www.bradescoseguros.com.br/clientes/produtos/plano-saude', 1, '2019-06-18 16:46:10'),
(4, 'Aeronáutica', '(81) 3322-6300', 'http://www.aer.mil.br/', 1, '2019-06-18 16:57:46'),
(5, 'Agemar', '(81) 4009-7181', 'http://www.agemar.com.br/', 1, '2019-06-18 16:58:52'),
(6, 'Allianz Saúde', '0800-722-8148', 'https://www.allianz.com.br/saude', 1, '2019-06-18 17:02:34'),
(7, 'Amepe Campe', '(81) 3036-3311', 'http://www.campe.org.br/', 1, '2019-06-18 17:04:46'),
(8, 'Assefaz', '0800-703-4545', 'http://www.assefaz.org.br/', 1, '2019-06-18 17:07:49'),
(9, 'Axa Assistance', '(11) 4196-5922', 'http://www.axa-assistance.com.br/', 1, '2019-06-18 17:10:06'),
(10, 'Banco Central', '(61) 3414-1324', 'https://www.bcb.gov.br/', 1, '2019-06-18 17:10:56'),
(11, 'Banco do Brasil', '0800-729-0080', 'https://www.cassi.com.br/', 1, '2019-06-18 17:12:51'),
(12, 'BNDES', '0800-707-7471', 'https://www.fapes.com.br/', 1, '2019-06-18 17:14:35'),
(13, 'Brandão', '(81) 3049-9800', 'http://www.fenamar.com.br/', 1, '2019-06-18 17:15:42'),
(14, 'Cabesp', '0800-722-2636', 'https://www.cabesp.com.br/', 1, '2019-06-18 17:18:25'),
(15, 'Camed', '0800-704-7886', 'https://www.camed.com.br/PortalCamed/', 1, '2019-06-18 17:20:49'),
(16, 'Capesesp', '0800-979-6191', 'https://www.capesesp.com.br/', 1, '2019-06-18 17:21:41'),
(17, 'CMA CGM', '(81) 3224-0373', 'http://www.cma-cgm.com/', 1, '2019-06-18 17:22:51'),
(18, 'Compesaprev', '(81) 3366-24447', 'https://www.compesaprev.com.br/', 1, '2019-06-18 17:24:52'),
(19, 'Conab', '(61) 3403-4575 / 3403-4580', 'https://www.conab.gov.br/', 1, '2019-06-18 17:26:19'),
(20, 'EAS Saúde', '(81) 4042-2102 / 3311-8419', 'https://www.eassaude.com.br/', 1, '2019-06-18 17:27:23'),
(21, 'Embratel / Pame / Teles', '0800-724-1013', 'http://www.pame.com.br/', 1, '2019-06-18 17:28:18'),
(22, 'Excelsior', '(81) 2125-1000', 'http://c1.qa.amil.com.br/institucional/#/', 1, '2019-06-18 17:29:22'),
(23, 'Fachesf', '0800-281-7533', 'http://www.fachesf.com.br/', 1, '2019-06-18 17:30:10'),
(24, 'Fisco Saúde', '(81) 3126-7730', 'http://www.fiscosaude.com.br/', 1, '2019-06-18 17:32:08'),
(25, 'Funcef', '0800-706-9000', 'https://www.funcef.com.br/', 1, '2019-06-18 17:33:01'),
(26, 'Fundação Fiat', '(31) 3304-3900', 'http://www.fundacaofiat.com.br/', 1, '2019-06-18 17:34:50'),
(27, 'Fusex', '(81) 2123-4820', 'http://www.hmar.eb.mil.br/index.php/administrativas/adm-fusex', 1, '2019-06-18 17:36:04'),
(28, 'Gama Saúde', '4004-0178 / 0800-722-0178', 'http://www.gamasaude.com.br/', 1, '2019-06-18 17:38:15'),
(29, 'Golden Cross', '0800-728-2001', 'http://www.goldencross.com.br/', 1, '2019-06-18 17:38:58'),
(30, 'Shineray Naval de Recife', '(81) 3036-9001 / 3036-9067', 'https://www.marinha.mil.br/om/hospital-naval-de-recife', 1, '2019-06-18 17:41:31'),
(31, 'IRB', '(11) 2588-0200', 'https://www.irbre.com/', 1, '2019-06-18 17:43:29'),
(32, 'IRH', '(81) 3183-4700', 'http://www.irh.pe.gov.br/', 1, '2019-06-18 17:44:28'),
(33, 'Infraero', '0800-645-0834', 'http://www4.infraero.gov.br/', 1, '2019-06-18 17:48:01'),
(34, 'Irmãos Britto', '(81) 3419-1360', 'http://www.ibritto.com.br', 1, '2019-06-18 17:49:07'),
(35, 'Mapfre', '0800-117-2833', 'https://www.mapfresaude.com.br/', 1, '2019-06-18 17:50:06'),
(36, 'Mediservice', '0800-727-9966', 'https://www.mediservice.com.br/', 1, '2019-06-18 17:51:18'),
(37, 'Mondial Assistance', '(11) 4331-5282', 'https://www.mondialtravel.com.br/', 1, '2019-06-18 17:53:45'),
(38, 'MSC', '(81) 3328-9217', 'https://www.msc.com/bra', 1, '2019-06-18 17:55:11'),
(39, 'Omint', '0800-726-4000', 'https://www.omint.com.br/', 1, '2019-06-18 17:56:34'),
(40, 'PM-PE', '(81) 3181-1480', 'http://www.pm.pe.gov.br/', 1, '2019-06-18 17:57:40'),
(41, 'Petrobrás', '0800-728-9001 / 0800-728-9001', 'http://www.br.com.br/', 1, '2019-06-18 17:59:01'),
(42, 'Postal Saúde', '(81) 3464-3950', 'http://postalsaude.com.br/', 1, '2019-06-18 18:00:50'),
(43, 'Sea Alliance', '0800-727-9966', 'https://www.sea-alliance.com/', 1, '2019-06-18 18:02:59'),
(44, 'Serpro', '(61) 2021-8000', 'http://www.serpro.gov.br/', 1, '2019-06-18 18:03:50'),
(45, 'Start', '(81) 3059-5959', 'http://startline.com.br/new/', 1, '2019-06-18 18:04:53'),
(46, 'Sulamérica', '4004-5903 / 0800-970-0200', 'https://portal.sulamericaseguros.com.br/', 1, '2019-06-18 18:07:21'),
(47, 'Superservice', '(81) 3424-5700', 'http://www.superservice.srv.br/', 1, '2019-06-18 18:08:18'),
(48, 'Unafisco Saúde', '0800-722-2388', 'https://unafiscosaude.org.br/site/', 1, '2019-06-18 18:09:45'),
(49, 'Unimed Caruaru', '(81) 2103-8600', 'https://www.unimed.coop.br/web/caruaru', 1, '2019-06-18 18:10:24'),
(50, 'Unimed Recife', '(81) 3198-2600', 'https://www.unimedrecife.com.br/', 1, '2019-06-18 18:11:01'),
(51, 'Williams Marítima', '(81) 3327-9200', 'http://williams.com.br/', 1, '2019-06-18 18:11:46'),
(52, 'Willian Sons', '(81) 3419-1300', 'https://www.wilsonsons.com.br/pt/grupo', 1, '2019-06-18 18:12:26'),
(53, 'Windrose', '(81) 2119-7171', 'http://www.windrose.com.br/', 1, '2019-06-18 18:13:45'),
(54, 'World Assist', '(11) 3120-4155', 'http://worldassist.com.br/teste2/', 1, '2019-06-18 18:18:07'),
(55, 'RH NYDUS', 'Ramal 2000', 'https://shineray.nydusrh.com/', 1, '2022-03-31 15:10:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_degree_damgs`
--

CREATE TABLE `tb_degree_damgs` (
  `id_degree_damg` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_degree_damg` varchar(64) NOT NULL,
  `days_degree_damg` varchar(4) DEFAULT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB AVG_ROW_LENGTH=2340 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_degree_damgs`
--

INSERT INTO `tb_degree_damgs` (`id_degree_damg`, `name`, `cod_degree_damg`, `days_degree_damg`, `descrition`, `created_at`) VALUES
(1, '(Grau 2) Incidente Leve ', '', '5', 'Enviar para o gestor e envolvidos, para analise com prazo para retorno de 5 dias.', '2024-04-08 20:16:46'),
(2, '(Grau 3) Incidente Moderado', '', '5', 'Enviar para o gestor e envolvidos, para analise com prazo para retorno de 5 dias.', '2024-04-08 20:17:28'),
(3, '(Grau 3) Incidente Grave', '', '3', 'Comunicar imediatamente a direção, qualidade, NSP. Análise no Protocolo de Londres com prazo para devolutiva em 3 dias.', '2024-04-08 20:17:52'),
(4, '(Grau 3) Incidente Óbito', '', '3', 'Comunicar imediatamente a direção, qualidade, NSP. Análise no Protocolo de Londres com prazo para retorno em 3 dias.', '2024-04-08 21:11:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_departments`
--

CREATE TABLE `tb_departments` (
  `id_department` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_department` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_departments`
--

INSERT INTO `tb_departments` (`id_department`, `name`, `cod_department`, `created_at`) VALUES
(24, 'Manutenção', '', '2026-01-23 16:38:14'),
(42, 'Qualidade', '', '2026-01-23 16:38:05'),
(58, 'Engenharia', '', '2026-01-23 16:37:54'),
(87, 'TI', '', '2026-01-23 16:37:37'),
(88, 'Diretoria', '', '2026-01-23 16:37:43'),
(89, 'Compras', '', '2026-01-23 16:38:29'),
(90, 'Comercial peças', '', '2026-01-23 16:38:36'),
(91, 'Almoxarifado', '', '2026-01-23 16:38:42'),
(92, 'Logística / Expedição', '', '2026-01-23 16:38:57'),
(93, 'Comexport', '', '2026-01-23 16:39:04'),
(94, 'Tagman', '', '2026-01-23 16:39:08'),
(95, 'Linha de produção', '', '2026-01-23 16:39:14'),
(96, 'Refeitório', '', '2026-01-23 16:39:22'),
(97, 'Segurança do trabalho', '', '2026-01-23 16:39:37'),
(98, 'Marketing', '', '2026-02-03 16:05:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_events`
--

CREATE TABLE `tb_events` (
  `id_event` int(11) NOT NULL,
  `name_event` varchar(264) NOT NULL,
  `description_event` mediumtext NOT NULL,
  `url_slug` varchar(264) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_event` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabela de Eventos';

--
-- Extraindo dados da tabela `tb_events`
--

INSERT INTO `tb_events` (`id_event`, `name_event`, `description_event`, `url_slug`, `id_user`, `dt_event`) VALUES
(223, '3', '3', '3', 17, '2024-04-01 19:33:12'),
(224, '2', '2', '2', 17, '2024-04-01 19:52:41'),
(237, 'Carnaval 2026', 'Folia está no ar, carnaval!!', 'carnaval-2026', 17, '2026-02-01 19:41:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_factoccurreds`
--

CREATE TABLE `tb_factoccurreds` (
  `id_factoccurred` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_factoccurred` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_factoccurreds`
--

INSERT INTO `tb_factoccurreds` (`id_factoccurred`, `name`, `cod_factoccurred`, `descrition`, `created_at`) VALUES
(1, 'Abordagem Inadequada', '', '', '2024-04-10 12:57:40'),
(2, 'Acidente com equipamento', '', '', '2024-04-10 12:59:48'),
(8, 'Acidente de trabalho', '', '', '2024-04-10 15:24:13'),
(9, 'Acidente Durante Procedimento', '', '', '2024-04-10 15:24:27'),
(10, 'Acionamento do TRR', '', '', '2024-04-10 15:24:32'),
(11, 'Admissão', '', '', '2024-04-10 15:24:37'),
(12, 'Alta Inadequada ', '', '', '2024-04-10 15:24:41'),
(13, 'Ambulância ', '', '', '2024-04-10 15:24:46'),
(14, 'Aprazamento não realizado', '', '', '2024-04-10 15:24:54'),
(15, 'Atraso Cirúrgico', '', '', '2024-04-10 15:24:59'),
(16, 'Atraso Maqueiro', '', '', '2024-04-10 15:25:05'),
(17, 'Atraso na Realização de diagnóstico', '', '', '2024-04-10 15:25:11'),
(18, 'Atraso na realização de procedimento', '', '', '2024-04-10 15:25:20'),
(19, 'Atraso no Envio da Prescrição', '', '', '2024-04-10 15:25:24'),
(20, 'Ausência de Formulários  ', '', '', '2024-04-10 15:25:28'),
(21, 'Ausência de Identificação de Dispositivos ', '', '', '2024-04-10 15:25:33'),
(22, 'Ausência de Laudo', '', '', '2024-04-10 15:25:37'),
(23, 'Ausência de Médico ', '', '', '2024-04-10 15:25:44'),
(24, 'Ausência de Pulseira', '', '', '2024-04-10 15:25:48'),
(25, 'Ausência de Registro', '', '', '2024-04-10 15:25:52'),
(26, 'Automedicação', '', '', '2024-04-10 15:25:57'),
(27, 'Óbito ', '', '', '2024-04-10 15:26:01'),
(28, 'Broncoaspiração', '', '', '2024-04-10 15:26:05'),
(29, 'Carro de Parada ', '', '', '2024-04-10 15:26:09'),
(30, 'Cirurgia Suspensa ', '', '', '2024-04-10 15:26:13'),
(31, 'Coleta Inadequada ', '', '', '2024-04-10 15:26:17'),
(32, 'Complicação Cirúrgica ', '', '', '2024-04-10 15:26:22'),
(33, 'Comportamento ', '', '', '2024-04-10 15:26:27'),
(34, 'Conduta Inadequada ', '', '', '2024-04-10 15:26:31'),
(35, 'Conflito ', '', '', '2024-04-10 15:26:35'),
(36, 'Conjuntivite', '', '', '2024-04-10 15:26:39'),
(37, 'Contratualização ', '', '', '2024-04-10 15:26:42'),
(38, 'Cuidado Geral ', '', '', '2024-04-10 15:26:46'),
(39, 'Cuidado inadequado ', '', '', '2024-04-10 15:26:52'),
(40, 'Dano Contra Bens', '', '', '2024-04-10 15:26:57'),
(41, 'Demora na retirada de materiais', '', '', '2024-04-10 15:27:02'),
(42, 'Desassistência', '', '', '2024-04-10 15:27:06'),
(43, 'Desassistência maqueiro', '', '', '2024-04-10 15:27:10'),
(44, 'Descarte Inadequado', '', '', '2024-04-10 15:27:14'),
(45, 'Descontinuidade de Prontuário ', '', '', '2024-04-10 15:27:22'),
(46, 'Descontinuidade de Boas Práticas', '', '', '2024-04-10 15:27:28'),
(47, 'Descontinuidade de Protocolo Controle Glicêmico ', '', '', '2024-04-10 15:27:32'),
(48, 'Descontinuidade de Protocolo Hemotransfusão', '', '', '2024-04-10 15:27:38'),
(49, 'Descontinuidade de Protocolo Jejum', '', '', '2024-04-10 15:27:43'),
(50, 'Descontinuidade de Protocolo Sedação e Analgesia', '', '', '2024-04-10 15:27:47'),
(51, 'Descumprimento de TRR', '', '', '2024-04-10 15:27:51'),
(52, 'Descumprimento do PGRSS', '', '', '2024-04-10 15:27:54'),
(53, 'Descumprimento do Protocolo de Cirurgia Segura', '', '', '2024-04-10 15:27:58'),
(54, 'Descumprimento do Protocolo de Identificação ', '', '', '2024-04-10 15:28:15'),
(55, 'Descumprimento do Protocolo der Prevenção de Queda', '', '', '2024-04-10 15:28:19'),
(56, 'Descumprimento de Sepse ', '', '', '2024-04-10 15:28:24'),
(57, 'Descumprimento do Protocolo Precaução ', '', '', '2024-04-10 15:28:28'),
(58, 'Descumprimento Normas de Limpeza', '', '', '2024-04-10 15:28:32'),
(59, 'Descumprimento Normas de paramentação  ', '', '', '2024-04-10 15:28:36'),
(60, 'Desperdício de insumo ', '', '', '2024-04-10 15:28:40'),
(61, 'Dieta Atrasada ', '', '', '2024-04-10 15:28:46'),
(62, 'Dieta Errada', '', '', '2024-04-10 15:28:50'),
(63, 'Dieta Erro de Administração ', '', '', '2024-04-10 15:28:56'),
(64, 'Dieta Erro de Dispensação', '', '', '2024-04-10 15:29:00'),
(65, 'Dieta Erro de Prescrição', '', '', '2024-04-10 15:29:12'),
(66, 'Dieta Não Administrada ', '', '', '2024-04-10 15:29:18'),
(67, 'Dispositivo Inadequado ', '', '', '2024-04-10 15:29:23'),
(68, 'Divergência de Registro', '', '', '2024-04-10 15:29:27'),
(69, 'Documento Não Preenchido', '', '', '2024-04-10 15:29:31'),
(70, 'Duplicidade em documentação ', '', '', '2024-04-10 15:29:36'),
(71, 'Enxoval Inadequado', '', '', '2024-04-10 15:29:40'),
(72, 'Enxoval incompleto', '', '', '2024-04-10 15:29:46'),
(73, 'Enxoval Insuficiente', '', '', '2024-04-10 15:29:50'),
(74, 'EPI Inadequado', '', '', '2024-04-10 15:29:54'),
(75, 'Equipamento Inadequado', '', '', '2024-04-10 15:29:58'),
(76, 'Equipamento Incompleto', '', '', '2024-04-10 15:30:02'),
(77, 'Erro de Diagnostico ', '', '', '2024-04-10 15:30:06'),
(78, 'Evasão', '', '', '2024-04-10 15:30:10'),
(79, 'Exame Não realizado', '', '', '2024-04-10 15:30:14'),
(80, 'Excesso de Material', '', '', '2024-04-10 15:30:18'),
(81, 'Extravasamento de Contraste', '', '', '2024-04-10 15:30:22'),
(82, 'Extravasamento de Medicamento', '', '', '2024-04-10 15:30:26'),
(83, 'Extravasamento de QT ', '', '', '2024-04-10 15:30:31'),
(84, 'Extravio', '', '', '2024-04-10 15:30:36'),
(85, 'Extubação acidental', '', '', '2024-04-10 15:30:40'),
(86, 'Extubação por rolha', '', '', '2024-04-10 15:30:44'),
(87, 'Falha de comunicação ', '', '', '2024-04-10 15:30:48'),
(88, 'Falha de Processo', '', '', '2024-04-10 15:30:52'),
(89, 'Falha de Sistema ', '', '', '2024-04-10 15:30:57'),
(90, 'Falha na Assistência', '', '', '2024-04-10 15:31:04'),
(91, 'Falha na Assistência de Equipe Médica', '', '', '2024-04-10 15:31:07'),
(92, 'Falha na Estrutura ', '', '', '2024-04-10 15:31:12'),
(93, 'Falha na Identificação da Medicação', '', '', '2024-04-10 15:31:16'),
(94, 'Falha na Identificação de Dispositivos', '', '', '2024-04-10 15:31:20'),
(95, 'Falha no Armazenamento', '', '', '2024-04-10 15:31:25'),
(96, 'Falha no controle de Insetos', '', '', '2024-04-10 15:31:29'),
(97, 'Falha no Equipamento', '', '', '2024-04-10 15:31:33'),
(98, 'Falta de material', '', '', '2024-04-10 15:31:38'),
(99, 'Flebite', '', '', '2024-04-10 15:31:44'),
(100, 'Formulários / documentos incompletos', '', '', '2024-04-10 15:31:48'),
(101, 'Formulários Incompletos', '', '', '2024-04-10 15:31:54'),
(102, 'Gestão de Acesso ao Cuidado', '', '', '2024-04-10 15:31:58'),
(103, 'Giro de Leito ', '', '', '2024-04-10 15:32:02'),
(104, 'Hemorragia ', '', '', '2024-04-10 15:32:05'),
(105, 'Higiene Inadequada do Paciente ', '', '', '2024-04-10 15:32:10'),
(106, 'Higienização e Limpeza Inadequada ', '', '', '2024-04-10 15:32:15'),
(107, 'Identificação do Paciente ', '', '', '2024-04-10 15:32:19'),
(108, 'Imobiliário', '', '', '2024-04-10 15:32:24'),
(109, 'Improcedente', '', '', '2024-04-10 15:32:28'),
(110, 'Inexistência de fluxo ', '', '', '2024-04-10 15:32:32'),
(111, 'Informação Errada no Sistema ou No documento', '', '', '2024-04-10 15:32:35'),
(112, 'Insumo vencido', '', '', '2024-04-10 15:32:39'),
(113, 'Intercorrência cirúrgica ', '', '', '2024-04-10 15:32:43'),
(114, 'IPCS', '', '', '2024-04-10 15:32:49'),
(115, 'Iras', '', '', '2024-04-10 15:32:53'),
(116, 'ISC ', '', '', '2024-04-10 15:32:58'),
(117, 'ITU', '', '', '2024-04-10 15:33:05'),
(118, 'Lesão de pele', '', '', '2024-04-10 15:33:09'),
(119, 'Lesão septo nasal', '', '', '2024-04-10 15:33:13'),
(120, 'Lesão por dispositivo', '', '', '2024-04-10 15:33:16'),
(121, 'LPP 1', '', '', '2024-04-10 15:33:21'),
(122, 'LPP 2', '', '', '2024-04-10 15:33:25'),
(123, 'LPP 3', '', '', '2024-04-10 15:33:30'),
(124, 'LPP 4', '', '', '2024-04-10 15:33:33'),
(125, 'LPP não classificável ', '', '', '2024-04-10 15:33:38'),
(126, 'Material inadequado ', '', '', '2024-04-10 15:33:41'),
(127, 'Material incompleto', '', '', '2024-04-10 15:33:58'),
(128, 'Material indisponível', '', '', '2024-04-10 15:34:03'),
(129, 'Material vencido ', '', '', '2024-04-10 15:34:08'),
(130, 'Medicação Atrasado ', '', '', '2024-04-10 15:34:13'),
(131, 'Medicação Erro de Administração', '', '', '2024-04-10 15:34:17'),
(132, 'Medicação Erro de Dispensação ', '', '', '2024-04-10 15:34:22'),
(133, 'Medicação Erro de Preparo', '', '', '2024-04-10 15:34:25'),
(134, 'Medicação Erro de Prescrição ', '', '', '2024-04-10 15:34:29'),
(135, 'Medicação Não Administrada', '', '', '2024-04-10 15:34:32'),
(136, 'Medicação Não Prescrita', '', '', '2024-04-10 15:34:36'),
(137, 'Medicação Paciente Alérgico', '', '', '2024-04-10 15:34:41'),
(138, 'Medicação Perdida', '', '', '2024-04-10 15:34:44'),
(139, 'Medicação Prescrita Duplicada', '', '', '2024-04-10 15:34:49'),
(140, 'Medicamento Errado', '', '', '2024-04-10 15:34:52'),
(141, 'Menor sem Acompanhamento', '', '', '2024-04-10 15:34:57'),
(142, 'Mews Incompleto', '', '', '2024-04-10 15:35:01'),
(143, 'Não se Aplica', '', '', '2024-04-10 15:35:06'),
(144, 'Obstrução de Dreno ', '', '', '2024-04-10 15:35:15'),
(145, 'Obstrução de Dreno', '', '', '2024-04-10 15:35:18'),
(146, 'Obstrução de SNE', '', '', '2024-04-10 15:35:22'),
(147, 'Obstrução de SVD ', '', '', '2024-04-10 15:35:26'),
(148, 'Obstrução de TOT', '', '', '2024-04-10 15:35:29'),
(149, 'Obstrução de TQT', '', '', '2024-04-10 15:35:34'),
(150, 'Obstrução PICC', '', '', '2024-04-10 15:35:38'),
(151, 'Paciente não colaborativa', '', '', '2024-04-10 15:35:42'),
(152, 'Paciente sem acompanhamento', '', '', '2024-04-10 15:35:46'),
(153, 'PAV ', '', '', '2024-04-10 15:35:50'),
(154, 'PCR', '', '', '2024-04-10 15:35:54'),
(155, 'Perda de AVC', '', '', '2024-04-10 15:35:57'),
(156, 'Perda de AVP', '', '', '2024-04-10 15:36:02'),
(157, 'Perda de CTI', '', '', '2024-04-10 15:36:06'),
(158, 'Perda de dreno', '', '', '2024-04-10 15:36:09'),
(159, 'Perda de GTT', '', '', '2024-04-10 15:36:15'),
(160, 'Perda de Material ', '', '', '2024-04-10 15:36:21'),
(161, 'Perda de PICC', '', '', '2024-04-10 15:36:24'),
(162, 'Perda de SNE', '', '', '2024-04-10 15:36:28'),
(163, 'Perda de SNG ', '', '', '2024-04-10 15:36:31'),
(164, 'Pneumonia não associada a AVM', '', '', '2024-04-10 15:36:36'),
(165, 'Preparo inadequado', '', '', '2024-04-10 15:36:40'),
(166, 'Prescrição de NPT atrasada', '', '', '2024-04-10 15:36:45'),
(167, 'Prescrição de NPT Errada', '', '', '2024-04-10 15:36:48'),
(168, 'Prescrição de NPT Ilegível ', '', '', '2024-04-10 15:36:52'),
(169, 'Prescrição de NPT incompleta ', '', '', '2024-04-10 15:36:56'),
(170, 'Presença de insetos', '', '', '2024-04-10 15:36:59'),
(171, 'Procedimento Inadequado', '', '', '2024-04-10 15:37:03'),
(172, 'Produto Vencido ', '', '', '2024-04-10 15:37:08'),
(173, 'Prontuário Retido em Setor', '', '', '2024-04-10 15:37:12'),
(174, 'Falha no Protocolo de AVC', '', '', '2024-04-10 15:37:17'),
(175, 'Falha no Protocolo de Sepse', '', '', '2024-04-10 15:37:21'),
(176, 'Falha no Protocolo de TEV ', '', '', '2024-04-10 15:37:25'),
(177, 'Quase queda', '', '', '2024-04-10 15:37:31'),
(178, 'Quebra de Barreira Asséptica', '', '', '2024-04-10 15:37:35'),
(179, 'Quebra de Conduta Profissional ', '', '', '2024-04-10 15:37:40'),
(180, 'Quebra de contratualização', '', '', '2024-04-10 15:37:44'),
(181, 'Quebra de fluxo', '', '', '2024-04-10 15:37:47'),
(182, 'Queda banheiro', '', '', '2024-04-10 15:37:56'),
(183, 'Queda Cadeira', '', '', '2024-04-10 15:38:00'),
(184, 'Queda escada/degrau', '', '', '2024-04-10 15:38:04'),
(185, 'Queda leito', '', '', '2024-04-10 15:38:07'),
(186, 'Queda maca', '', '', '2024-04-10 15:38:13'),
(187, 'Queda piso molhado ', '', '', '2024-04-10 15:38:17'),
(188, 'Queda própria altura', '', '', '2024-04-10 15:38:21'),
(189, 'Queimadura ', '', '', '2024-04-10 15:38:35'),
(190, 'Queixa técnica ', '', '', '2024-04-10 15:38:38'),
(191, 'Reação adversa', '', '', '2024-04-10 15:38:42'),
(192, 'Reação Alérgica ', '', '', '2024-04-10 15:38:48'),
(193, 'Reação pós anestésica', '', '', '2024-04-10 15:38:52'),
(194, 'Reação transfusional', '', '', '2024-04-10 15:38:56'),
(195, 'Recusa de recebimento da CME', '', '', '2024-04-10 15:39:00'),
(196, 'Registro Indevido', '', '', '2024-04-10 15:39:03'),
(197, 'Regulação de Vaga', '', '', '2024-04-10 15:39:06'),
(198, 'Repetição de exame', '', '', '2024-04-10 15:39:15'),
(199, 'Reposição de carro de parada', '', '', '2024-04-10 15:39:19'),
(200, 'Falha na Segregação de resíduos', '', '', '2024-04-10 15:39:24'),
(201, 'Solicitação de insumo acima da cota', '', '', '2024-04-10 15:39:28'),
(202, 'Suspensão de exame', '', '', '2024-04-10 15:39:33'),
(203, 'Tempo de espera prolongada', '', '', '2024-04-10 15:39:37'),
(204, 'Transferência inadequada ', '', '', '2024-04-10 15:39:41'),
(205, 'Traqueite', '', '', '2024-04-10 15:39:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_file`
--

CREATE TABLE `tb_file` (
  `id_file` int(11) NOT NULL,
  `name_notificacao` varchar(50) NOT NULL,
  `id_notificacao` int(11) NOT NULL,
  `dt_file` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_incidents`
--

CREATE TABLE `tb_incidents` (
  `id_incident` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_incident` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_incidents`
--

INSERT INTO `tb_incidents` (`id_incident`, `name`, `cod_incident`, `descrition`, `created_at`) VALUES
(1, 'Administração Clínica', '', NULL, '2024-04-03 12:03:32'),
(2, 'Processo Clínico / Procedimentos', '', NULL, '2024-04-03 12:05:00'),
(3, 'Documentação', '', NULL, '2024-04-03 12:05:04'),
(4, 'IRAS', '', NULL, '2024-04-03 12:05:08'),
(5, 'Medicação / Fluídos Endovenosos', '', NULL, '2024-04-03 12:05:12'),
(6, 'Hemoderivados', '', NULL, '2024-04-03 12:05:16'),
(7, 'Nutrição', '', NULL, '2024-04-03 12:05:20'),
(8, 'Gases / Oxigênio', '', NULL, '2024-04-03 12:05:23'),
(9, 'Equipamento Médico e Produtos Médico-Montadora (Tecnovigilância)', '', NULL, '2024-04-03 12:05:27'),
(10, 'Comportamento', '', NULL, '2024-04-03 12:05:32'),
(11, 'Acidentes com Paciente/Colaborador', '', NULL, '2024-04-03 12:05:36'),
(12, 'Estrutura', '', NULL, '2024-04-03 12:05:40'),
(13, 'Gerenciamento de Recursos / Organizacional', '', NULL, '2024-04-03 12:05:45'),
(14, 'Não se Aplica', '', NULL, '2024-04-03 12:05:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_internacionalsecuritys`
--

CREATE TABLE `tb_internacionalsecuritys` (
  `id_internacionalsecurity` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_internacionalsecurity` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_internacionalsecuritys`
--

INSERT INTO `tb_internacionalsecuritys` (`id_internacionalsecurity`, `name`, `cod_internacionalsecurity`, `descrition`, `created_at`) VALUES
(1, 'Meta 1', '', 'Identificação do paciente', '2024-04-22 19:29:29'),
(2, 'Meta 2', '', 'Melhorar a comunicação entre os profissionais', '2024-04-22 19:29:29'),
(3, 'Meta 3', '', 'Segurança na prescrição, no uso e na administração de medicamentos', '2024-04-22 19:29:29'),
(4, 'Meta 4', '', 'Assegurar cirurgia em local de intervenção, procedimentos e paciente corretos', '2024-04-22 19:29:29'),
(5, 'Meta 5', '', 'Higienizar as mãos para evitar infecções', '2024-04-22 19:29:29'),
(6, 'Meta 6', '', 'Avalie os pacientes em relação ao risco de queda e lesão por pressão, estabelecendo ações precentivas', '2024-04-22 19:29:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_notificacao`
--

CREATE TABLE `tb_notificacao` (
  `id_notificacao` int(11) NOT NULL,
  `dt_notificacao` date NOT NULL DEFAULT current_timestamp(),
  `nome_pac` varchar(150) DEFAULT NULL,
  `dt_nasc` date DEFAULT NULL,
  `atendimento` varchar(45) DEFAULT NULL,
  `registro` int(10) DEFAULT NULL,
  `dt_internamento` date DEFAULT current_timestamp(),
  `patient` varchar(3) DEFAULT NULL,
  `dt_oco` date DEFAULT current_timestamp(),
  `hr_oco` time DEFAULT NULL,
  `st_cante` varchar(100) DEFAULT NULL,
  `st_cado` varchar(100) DEFAULT NULL,
  `class_incident` varchar(45) DEFAULT NULL,
  `class_occ` varchar(100) DEFAULT NULL,
  `degree_damg` varchar(100) DEFAULT NULL,
  `descricao` mediumtext DEFAULT NULL,
  `solution` mediumtext DEFAULT NULL,
  `patientsecurity` varchar(100) DEFAULT NULL,
  `qclass_incident` varchar(45) DEFAULT NULL,
  `qclass_occ` varchar(100) DEFAULT NULL,
  `qdegree_damg` varchar(100) DEFAULT NULL,
  `return_date` text DEFAULT NULL,
  `process` varchar(45) DEFAULT NULL,
  `problem` varchar(45) DEFAULT NULL,
  `fact_occurred` varchar(45) DEFAULT NULL,
  `validation_date` text DEFAULT NULL,
  `proposed_action` mediumtext DEFAULT NULL,
  `eventinvestigation` varchar(3) DEFAULT NULL,
  `internacionalsecurity` varchar(100) DEFAULT NULL,
  `conclusion` varchar(45) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT current_timestamp(),
  `id_manual` varchar(10) DEFAULT NULL,
  `id_int` int(11) DEFAULT NULL,
  `id_notificacao_without_year` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_notificacao`
--

INSERT INTO `tb_notificacao` (`id_notificacao`, `dt_notificacao`, `nome_pac`, `dt_nasc`, `atendimento`, `registro`, `dt_internamento`, `patient`, `dt_oco`, `hr_oco`, `st_cante`, `st_cado`, `class_incident`, `class_occ`, `degree_damg`, `descricao`, `solution`, `patientsecurity`, `qclass_incident`, `qclass_occ`, `qdegree_damg`, `return_date`, `process`, `problem`, `fact_occurred`, `validation_date`, `proposed_action`, `eventinvestigation`, `internacionalsecurity`, `conclusion`, `update_at`, `id_manual`, `id_int`, `id_notificacao_without_year`) VALUES
(2224, '0000-00-00', '', NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', '', NULL, '', '', NULL, NULL, NULL, NULL, '', '', '', NULL, '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_occurrences`
--

CREATE TABLE `tb_occurrences` (
  `id_occurrence` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `days_occurrence` varchar(6) DEFAULT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `cod_occurrence` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_occurrences`
--

INSERT INTO `tb_occurrences` (`id_occurrence`, `name`, `days_occurrence`, `descrition`, `cod_occurrence`, `created_at`) VALUES
(1, 'Improcedente', '0', 'Devolver ao notificante.', '', '2024-04-08 21:26:29'),
(2, 'Não Conformidade', '15', 'Enviar para os gestores e envolvidos, para revisão de contrato e/ou fluxo de interface - com 15 dias.', '', '2024-04-09 17:40:07'),
(3, 'Circunstância de Risco', '15', 'Enviar para os gestores e envolvidos para avaliação e ações de melhorias.  - com 15 dias.', '', '2024-04-09 17:40:07'),
(4, 'Near Miss', '10', 'Enviar para os gestores e envolvidos, para avaliar matriz de perigos e acompanhar.   - com 10 dias.', '', '2024-04-09 17:40:07'),
(5, 'Incidente Sem Dano', '10', 'Enviar para o gestor e envolvidos, para analise com prazo para retorno de 10 dias. ', '', '2024-04-08 21:27:33'),
(6, 'Incidente Com Dano', '-19999', 'Habilita o campo classificação do Dano.', '', '2024-04-09 17:40:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_patientsecuritys`
--

CREATE TABLE `tb_patientsecuritys` (
  `id_patientsecurity` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_patientsecurity` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_patientsecuritys`
--

INSERT INTO `tb_patientsecuritys` (`id_patientsecurity`, `name`, `cod_patientsecurity`, `descrition`, `created_at`) VALUES
(1, 'Nunca – nunca ocorreu', '', '', '2024-04-11 17:08:02'),
(2, ' Remota – 2 x no mês ', '', '', '2024-04-11 17:08:15'),
(3, 'Incomum -  3 x no mês', '', '', '2024-04-11 17:08:21'),
(4, 'Ocasional – 4 x no mês', '', '', '2024-04-11 17:08:27'),
(5, 'Frequente -  5 x ou mais no mês ', '', '', '2024-04-11 17:08:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_photos`
--

CREATE TABLE `tb_photos` (
  `id_photo` int(11) NOT NULL,
  `name_photo` varchar(50) NOT NULL,
  `id_event` int(11) NOT NULL,
  `dt_photo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_photos`
--

INSERT INTO `tb_photos` (`id_photo`, `name_photo`, `id_event`, `dt_photo`) VALUES
(2415, '232-1.jpg', 232, '2026-02-01 13:34:45'),
(2416, '233-1.jpg', 233, '2026-02-01 13:35:17'),
(2430, '223-1.jpg', 223, '2026-02-01 18:25:35'),
(2431, '223-2.jpg', 223, '2026-02-01 18:25:35'),
(2432, '223-3.jpg', 223, '2026-02-01 18:25:35'),
(2433, '224-1.jpg', 224, '2026-02-01 18:31:25'),
(2434, '224-2.jpg', 224, '2026-02-01 18:31:25'),
(2439, '237-1.jpg', 237, '2026-02-02 14:34:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_photospost`
--

CREATE TABLE `tb_photospost` (
  `id_photo` int(11) NOT NULL,
  `name_photo` varchar(50) NOT NULL,
  `id_post` int(11) NOT NULL,
  `dt_photo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_photosuser`
--

CREATE TABLE `tb_photosuser` (
  `id_photo` int(11) NOT NULL,
  `name_photo` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_photo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_photosuser`
--

INSERT INTO `tb_photosuser` (`id_photo`, `name_photo`, `id_user`, `dt_photo`) VALUES
(17, '17.jpg', 17, '2026-01-21 17:46:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_popups`
--

CREATE TABLE `tb_popups` (
  `id_popup` int(11) NOT NULL,
  `popup_title` varchar(264) NOT NULL,
  `popup_active` tinyint(4) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_popup` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_posts`
--

CREATE TABLE `tb_posts` (
  `id_post` int(11) NOT NULL,
  `titulo` varchar(264) NOT NULL,
  `autor` varchar(64) NOT NULL,
  `texto` text NOT NULL,
  `url_slug` varchar(264) NOT NULL,
  `post_active` tinyint(4) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dtpost` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_posts`
--

INSERT INTO `tb_posts` (`id_post`, `titulo`, `autor`, `texto`, `url_slug`, `post_active`, `id_user`, `dtpost`) VALUES
(477, 'Premiações', 'Clécio Lins Bezerra', '  Mais de 2 milhões de prêmios ', 'premiacoes', 0, 17, '2022-10-03 09:52:07'),
(839, 'Shineray', 'Clécio Lins Bezerra', 'Nossa montadora Shineray do Brasil', 'shineray', 1, 17, '2026-01-23 18:18:51'),
(840, 'Moto 250F', 'Clécio Lins Bezerra', '  O painel da 250F é 100% digital, oferecendo uma visão clara das informações essenciais. Ele exibe o indicador de combustível, velocidade, marcha, neutro, conta giros e odômetro. O painel proporciona praticidade e segurança, garantindo que todas as informações necessárias fiquem visíveis ao alcance dos olhos.', 'moto-250f', 1, 17, '2026-01-23 18:21:01'),
(841, 'Moto 200', 'Clécio Lins Bezerra', '  Conheça a Storm200: Um modelo crossover com design arrojado, mais potência, desempenho e segurança para o seu dia a dia. A Storm conta com sistema de injeção eletrônica, freio ABS de dois canais e 200 cilindradas.  ', 'moto-200', 1, 17, '2026-01-23 18:21:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_problems`
--

CREATE TABLE `tb_problems` (
  `id_problem` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_problem` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_problems`
--

INSERT INTO `tb_problems` (`id_problem`, `name`, `cod_problem`, `descrition`, `created_at`) VALUES
(2, 'teste', '', '', '2024-04-11 19:02:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_processs`
--

CREATE TABLE `tb_processs` (
  `id_process` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cod_process` varchar(64) NOT NULL,
  `descrition` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_processs`
--

INSERT INTO `tb_processs` (`id_process`, `name`, `cod_process`, `descrition`, `created_at`) VALUES
(1, 'Administração Clínica', '', '', '2024-04-11 17:55:57'),
(3, 'Processo Clínico / Procedimentos', '', '', '2024-04-11 17:56:03'),
(4, 'Documentação', '', '', '2024-04-11 17:56:07'),
(5, 'IRAS', '', '', '2024-04-11 17:56:11'),
(6, 'Medicação / Fluídos Endovenosos', '', '', '2024-04-11 17:56:14'),
(7, 'Hemoderivados', '', '', '2024-04-11 17:56:20'),
(8, 'Nutrição', '', '', '2024-04-11 17:56:25'),
(9, 'Gases / Oxigênio', '', '', '2024-04-11 17:56:29'),
(10, 'Equipamento Médico e Produtos Médico-Montadora (Tecnovigilância)', '', '', '2024-04-11 17:56:33'),
(11, 'Comportamento', '', '', '2024-04-11 17:56:37'),
(12, 'Acidentes com Paciente/Colaborador', '', '', '2024-04-11 17:56:42'),
(13, 'Estrutura', '', '', '2024-04-11 17:56:46'),
(14, 'Gerenciamento de Recursos / Organizacional', '', '', '2024-04-11 17:56:50'),
(15, 'Não se Aplica', '', '', '2024-04-11 17:56:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_ramais`
--

CREATE TABLE `tb_ramais` (
  `id_agenda` int(11) NOT NULL,
  `unidade` varchar(128) DEFAULT NULL,
  `setor_sala` varchar(128) DEFAULT NULL,
  `colaborador` varchar(128) DEFAULT NULL,
  `ddr` varchar(128) DEFAULT NULL,
  `ramal` int(11) DEFAULT NULL,
  `celular` varchar(128) DEFAULT NULL,
  `emails` varchar(128) DEFAULT NULL,
  `ativo` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_ramais`
--

INSERT INTO `tb_ramais` (`id_agenda`, `unidade`, `setor_sala`, `colaborador`, `ddr`, `ramal`, `celular`, `emails`, `ativo`) VALUES
(1, 'Boa Viagem', 'Diretoria', 'Romulo Pina', '3464-8750', 8803, '', 'romulo@grupobci.rec.br', 'S'),
(2, 'Boa Viagem', 'Diretoria', 'Victor Menezes', '3464-8750', 8802, '99323-0740', 'victormenezes@grupobci.rec.br', 'S'),
(3, 'Boa Viagem', 'Diretoria', 'João Lidio', '3464-8768', 8768, '', 'joaolidio@grupobci.rec.br', 'S'),
(5, 'Boa Viagem', 'Diretoria', 'Marcos Menezes', '3464-8750', 8723, '', 'mm@grupobci.rec.br', 'S'),
(6, 'Boa Viagem', 'Diretoria', 'Paulo Perez', '3464-8750', 8722, '', 'pperez@grupobci.rec.br', 'S'),
(16, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Mariana Breckenfeld', '3464-8750', 8821, '', 'marianabreckenfeld@grupobci.rec.br', 'N'),
(22, 'Suape', 'Copa', 'Patrícia', '2127-4350', 4302, '', '', 'S'),
(25, 'Boa Viagem', 'Combustível', 'Gabriel Pontes', '3464-8750', 8846, '', 'gabrielpontes@grupobci.rec.br', 'S'),
(29, 'Boa Viagem', 'Comercial Motos', 'Claudio Barreto', '3464-8793', 8793, '98863-6143', 'claudiobarreto@grupobci.rec.br', 'S'),
(34, 'Boa Viagem', 'Financeiro/Contas a Pagar  ', 'Carlos Oliveira', '3464-8759', 8759, '', 'carlosoliveira@grupobci.rec.br', 'S'),
(35, 'Boa Viagem', 'Financeiro/Contas a Pagar  ', 'Vilcon Paz', '3464-8753', 8753, '99323-5006', 'vilconpaz@grupobci.rec.br', 'S'),
(36, 'Boa Viagem', 'Financeiro/Contas a Receber  ', 'Andre Pessoa', '3464-8756', 8756, '', 'andrepessoa@grupobci.rec.br', 'S'),
(37, 'Boa Viagem', 'Financeiro/Contas a Receber  ', 'Luciene Neves', '3464-8766', 8766, '99323-3036', 'lucieneneves@grupobci.rec.br', 'S'),
(42, 'Boa Viagem', 'Copa', 'Luiz e Luciana', '3464-8750', 8724, '', '', 'S'),
(45, 'Boa Viagem', 'Planejamento e Gestão/Controladoria  ', 'Ana Barbara', '3464-8750', 8726, '98863-6141', 'anabarbara@grupobci.rec.br', 'S'),
(46, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Evelye Freitas', '3464-8750', 8738, '', 'evelyefreitas@grupobci.rec.br', 'S'),
(49, 'Boa Viagem', 'Faturamento/Fiscal', 'Adriano Silva', '3464-8791', 8791, '99158-8898', 'adrianosilva@grupobci.rec.br', 'S'),
(50, 'Boa Viagem', 'Financeiro/Contas a Receber', 'Michelly Santana', '3464-8778', 8778, '99323-3055', 'michellysantana@grupobci.rec.br', 'S'),
(51, 'Boa Viagem', 'Financeiro/Contas a Pagar', ' Alfredo Cesar', '', 0, '99163-5651', '', 'N'),
(52, 'Boa Viagem', 'Gerência', 'Patrícia Barbosa', '3464-8774', 8774, '99159-3628', 'patriciabarbosa@grupobci.rec.br', 'S'),
(53, 'Boa Viagem', 'Fiscal', 'Roberta Santos', '3464-8750', 8824, '', 'robertasantos@grupobci.rec.br', 'S'),
(56, 'Boa Viagem', 'Fiscal', 'Elisangela Karla', '3464-8790', 8790, '', 'elisangelamonteiro@grupobci.rec.br', 'S'),
(62, 'Boa Viagem', 'Contábil', 'Deyse Lima', '3464-8750', 8737, '99322-8598', 'deyselima@grupobci.rec.br', 'S'),
(63, 'Boa Viagem', 'Contábil  ', 'Lindicelia', '3464-8750', 8739, '', 'lindicelialima@grupobci.rec.br', 'S'),
(66, 'Boa Viagem', 'Jurídico', 'Thais A. Bader', '3464-8772', 8772, '', 'thaisbader@grupobci.rec.br', 'S'),
(76, 'Boa Viagem', 'Recepção Boa Viagem', 'Maria Josiane', '3464-8750', 8816, '', 'recepcaobv@grupobci.rec.br', 'S'),
(83, 'Suape', 'Administrativo', 'George Gadelha', '2127-4381', 4381, '99159-2242', 'georgegadelha@shineraydobrasil.com.br', 'S'),
(86, 'Boa Viagem', 'Secretaria', 'Geralda Santana', '3464-8751', 8751, '99163-8876', 'geraldasantana@grupobci.rec.br', 'S'),
(88, 'São Paulo', 'Secretaria', 'Silvana Oliveira', '(11) 4550-1003', 0, '99323-0762', 'silvanaoliveira@grupobci.rec.br', 'S'),
(90, 'Boa Viagem', 'Pós-Vendas', 'Pós-Vendas', '', 8833, '', '', 'S'),
(92, 'Boa Viagem', 'Tecnologia da Informação  ', 'Amanda Santos', '3464-8757', 8757, '', 'amandasantos@grupobci.rec.br', 'S'),
(101, 'Boa Viagem', 'Administrativo', 'Pedro Lucas', '3464-8750', 8883, '', 'pedrolucas@grupobci.rec.br', 'S'),
(104, 'Boa Viagem', 'Diretoria', 'Luciano Menezes', '3464-8750', 8721, '', 'luciano@grupobci.rec.br', 'S'),
(110, 'Suape', 'Portaria', 'Portaria Central', '2127-4350', 4350, '99245-2361<br>99245-3504', 'portaria@grupobci.rec.br', 'S'),
(112, 'Suape', 'Coordenadora Administrativa', 'Juliana Carneiro', '2127-4352', 4352, '99245-1769', 'julianacarneiro@grupobci.rec.br', 'S'),
(113, 'Suape/Boa Viagem', 'Diretoria', 'Edinho', '2127-4353', 4353, '99172-6593', 'edinho@grupobci.rec.br', 'S'),
(115, 'Suape', 'Operações/Logística', 'Jacimar Nunes', '2127-4357', 4357, '99299-9753', 'jacimar@grupobci.rec.br', 'S'),
(128, 'Suape', 'Gerente de Operações', 'Ademar Nascimento', '2127-4388', 4388, '99407-6059', 'ademar@shineraydobrasil.com.br', 'S'),
(141, 'Suape', 'Sala de Reunião', 'Sala 01 (1º Andar)', '', 4363, '', '', 'S'),
(142, 'Suape', 'Tecnologia da Informação', 'Anderson Monteiro', '2127-4358', 4358, '(81) 98237-8722', 'andersonmonteiro@shineraydobrasil.com.br', 'S'),
(148, 'Suape', 'Refeitório', 'Cozzi', '2127-4367', 4367, '', '', 'S'),
(149, 'Boa Viagem', 'Faturamento/Fiscal', 'Andreson Silva', '3464-8755', 8755, '99173-0264', 'andresonsilva@grupobci.rec.br', 'S'),
(152, 'Suape', 'Comercial Peças', 'Luana Cruz', '2127-4378', 4378, '99323-3073', 'luanacruz@shineraydobrasil.com.br', 'S'),
(160, 'Suape', 'Produção/Motos', 'Aury Veras', '2127-4350', 4433, '(81) 98553-7384', 'auryveras@shineraydobrasil.com.br', 'S'),
(171, 'Suape', 'Operações/Administrativo', 'Givanildo Silva', '', 0, '93232-0731', '', 'S'),
(175, 'Boa Viagem', 'Portaria (Guarita)', 'Jordão', '3464-8770', 8770, '', '', 'S'),
(178, 'Suape', 'Diretoria', 'Léo Toscano', '2127-4387', 4387, '(81) 99971-7148', 'leotoscano@shineraydobrasil.com.br', 'S'),
(179, 'Suape', 'RH/SESMT', 'Jadicely Lima', '2127-4366', 4366, '99407-7029', 'jadiceleylima@grupobci.rec.br', 'S'),
(185, 'Boa Viagem', 'Diretoria', 'Hugo Menezes', '3464-8769', 8769, '', 'hugo@grupobci.rec.br', 'S'),
(187, 'Boa Viagem', 'Administrativo', 'Iaralane Paiva', '3464-8792', 8792, '99292-4582', 'iaralanepaiva@grupobci.rec.br', 'S'),
(188, 'Boa Viagem', 'RH/DP', 'Graziele Louzada', '3464-8795', 8795, '99323-0749', 'grazielelouzada@grupobci.rec.br', 'S'),
(195, 'Boa Viagem', 'Financeiro/Contas a Pagar  ', 'Beatriz Fechine', '3464-8750', 8729, '', 'beatrizfechine@grupobci.rec.br', 'S'),
(208, 'Boa Viagem', 'Combustível', 'Danielle Monteiro', '3464-8761', 8761, '99161-5585', 'daniellemonteiro@grupobci.rec.br', 'S'),
(210, 'Boa Viagem', 'Trading', 'Walcley Viana', '3464-8782', 8782, '', 'walcleyviana@grupobci.rec.br', 'S'),
(213, 'Boa Viagem', 'Trading/Comercial Motos/Frotas', 'Thomas Medeiros ', '3464-8750', 8809, '', 'thomasmedeiros@grupobci.rec.br', 'S'),
(221, 'Boa Viagem', 'Copa Diretoria', '', '', 8732, '', '', 'S'),
(223, 'São Paulo', 'Escritório SP', 'Renato Soares', '', 0, '99323-2460', '', 'S'),
(227, 'Boa Viagem', 'Sala de Reunião', 'Auditório', '', 8815, '', '', 'S'),
(228, 'Boa Viagem', 'Sala de Reunião', 'Sala 01 (1º Andar)', '', 8820, '', '', 'S'),
(229, 'Boa Viagem', 'Sala de Reunião', 'Sala 02 (1º Andar)', '', 8834, '', '', 'S'),
(230, 'Boa Viagem', 'Refeitorio BV (Copa)', '', '', 8825, '', '', 'S'),
(231, 'Boa Viagem', 'Secretaria', 'Enaile Rodrigues', '3464-8750', 8725, '', 'enailerodrigues@grupobci.rec.br', 'S'),
(233, 'Boa Viagem', 'RH/DP', 'Tarciana Santana', '3464-8796', 8796, '99323-0749', 'tarcianasantana@grupobci.rec.br', 'S'),
(235, 'Boa Viagem', 'Combustível', 'Everton Nascimento', '3464-8785', 8785, '99294-8800\n\n', 'evertonnascimento@grupobci.rec.br', 'S'),
(238, 'Boa Viagem', 'Fiscal', 'Liliane Moraes', '3464-8750', 8827, '', 'lilianemoraes@grupobci.rec.br', 'S'),
(240, 'Boa Viagem', 'Combustível', 'Manuel Silva', '3464-8783', 8783, '99323-3440', 'manuelsilva@grupobci.rec.br', 'n'),
(241, 'Boa Viagem', 'Frota', 'Roberta Barbosa', '3464-8781', 8781, '99163-9771', 'robertabarbosa@grupobci.rec.br', 'S'),
(242, 'Fortaleza', 'Representante Comercial', 'Lecio Sampaio', '', 0, '(85) 99106-4296', 'leciosampaio@shineraydobrasil.com.br', 'n'),
(245, 'Suape', 'Qualidade', 'Gabriela Silva', '2127-4350', 4307, '', 'gabrielasilva@shineraydobrasil.com.br', 'S'),
(246, 'Boa Viagem', 'Comercial Motos', 'Luiz Henrique Cavalcanti', '3464-8762', 8762, '99323-3098', 'luizcavalcanti@shineraydobrasil.com.br', 'N'),
(247, 'Boa Viagem', 'Comercial Motos', 'Jéssica Veiga', '3464-8763', 8763, '98103-3136', 'jessicaveiga@shineraydobrasil.com.br', 'S'),
(248, 'Boa Viagem', 'Comercial Motos', 'Yvila Thamires S. Ribeiro', '3464-8764', 8764, '99322-9560', 'yvilaribeiro@shineraydobrasil.com.br', 'S'),
(249, 'Boa Viagem', 'Frota', 'Elza Silva', '3464-8780', 8780, '99163-9771', 'elzasilva@grupobci.rec.br', 'S'),
(250, 'Boa Viagem', 'Tecnologia da Informação', 'Nayane Cordeiro', '3464-8776', 8776, '', 'nayanecordeiro@grupobci.rec.br', 'S'),
(251, 'Boa Viagem', 'Combustível', 'Alessandra Freitas', '3464-8779', 8779, '99163-1798', 'alessandrafreitas@grupobci.rec.br', 'S'),
(252, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Ivanise Lavinha Lima', '3464 8750', 8881, '98863-6052', 'ivaniselima@grupobci.rec.br', 'S'),
(254, 'Suape', 'RH/SESMT', 'Mery Helem', '2127-4354', 4354, '98288-5094', 'merysilva@shineraydobrasil.com.br', 'S'),
(255, 'Boa Viagem', 'Marketing', 'Ayó Paulino', '3464-8765', 8765, '98275-1526', 'ayopaulino@grupobci.rec.br', 'S'),
(256, 'Boa Viagem', 'Faturamento/Fiscal', 'Carlos Souza', '3464-8756', 8754, '', 'carlossouza@grupobci.rec.br', 'S'),
(259, 'Boa Viagem', 'Combustível', 'Artur Nascimento', '3464-8787', 8787, '99293-1243', 'arturnascimento@grupobci.rec.br', 'S'),
(260, 'Boa Viagem', 'Combustível', 'Valter Silva', '3464-8750', 8743, '98257-6868', 'valtersilva@grupobci.rec.br', 'S'),
(261, 'Suape', 'Logística', 'Geanderson Batista dos Santos', '2127-4385', 4385, '', 'geandersonsantos@shineraydobrasil.com.br', 'S'),
(262, 'Boa Viagem', 'RH/DP', 'Ana Patrícia', '3464-8750', 8742, '', 'anapatricia@grupobci.rec.br', 'S'),
(263, 'Boa Viagem', 'Tecnologia da Informação', 'Dialison Melo', '3464-8758', 8758, '', 'dialisonmelo@grupobci.rec.br', 'S'),
(264, 'Boa Viagem', 'Contábil', 'Ygo Gomes', '3464-8794', 8794, '', 'ygogomes@grupobci.rec.br', 'S'),
(265, 'Boa Viagem', 'Comercial Motos', 'Giovanna Andrade', '3464-8760', 8760, '985536804', 'giovannaandrade@shineraydobrasil.com.br', 'S'),
(267, 'Boa Viagem', 'Faturamento/Fiscal', 'Cleybson Nascimento', '3464-8750', 8745, '', 'cleybsonnascimento@grupobci.rec.br', 'S'),
(268, 'Boa Viagem', 'BCIPharma', 'Lucidalva Cavalcanti', '2127-4354', 4354, '98288-5094', 'lucidalvacavalcanti@bcipharma.com.br', 'n'),
(269, 'Suape', 'Comercial Peças ', 'Jaqueline Silva', '2127-4351', 4351, '98277-2552', 'jaquelinesilva@shineraydobrasil.com.br', 'S'),
(270, 'Suape', 'Administrativo', 'Fernanda Oliveira', '2127-4379', 4379, '99159-2242', 'fernandaoliveira@grupobci.rec.br', 'S'),
(272, 'Boa Viagem', 'Marketing', 'Sofia Menezes', '3464-8750', 8850, '', 'sofiamenezes@shineraydobrasil.com.br', 'S'),
(274, 'Suape', 'BCIPharma', 'Tiago Bezerra', '2127-4350', 4406, '', 'tiagobezerra@bcipharma.com.br', 'N'),
(275, 'Boa Viagem', 'BCIPharma', 'Hedel Fayad', '3464-8750', 8808, '98121-1080', 'hedelfayad@bcipharma.com.br', 'N'),
(276, 'Suape', 'Pós-Vendas', 'Bruno Vasconcelos', '(81) 3464-8750', 4363, '(81) 99207-0974', 'brunovasconcelos@shineraydobrasil.com.br', 'S'),
(277, 'Suape', 'BCIPharma', 'Vicente Neto', '2127-4350', 4406, '', 'aprendizbcisuape@bcipharma.com.br', 'N'),
(278, 'Boa Viagem', 'Combustível', 'Anderson Pontes', '3464-8798', 8798, '98218-1957', 'andersonpontes@grupobci.rec.br', 'S'),
(279, 'Pernambuco', 'Lojas', 'Loja Shineray Electric  - Pina', '', 0, '(81) 98155-3488', 'lojapina@shineraydobrasil.com.br', 'S'),
(280, 'Pernambuco', 'Lojas', 'Loja Shineray Electric  - Outlet', '', 0, '(81) 99295-8045', 'lojaoutlet@shineraydobrasil.com.br', 'S'),
(281, 'São Paulo', 'Lojas', 'Loja Shineray Electric- Moema', '', 0, '(11) 91229-7319', 'lojamoemasp@shineraydobrasil.com.br', 'S'),
(284, 'São Paulo', 'Lojas', 'Loja Shineray Electric  - Osasco', '', 0, '(11) 93081-2356', 'lojaosascosp@shineraydobrasil.com.br', 'N'),
(285, 'Ceará', 'Lojas', 'Loja Shineray Electric  - Fortaleza', '', 0, '(85) 98218-0588', 'lojafortalezace@shineraydobrasil.com.br', 'N'),
(287, 'Boa Viagem', 'Contábil', 'Rogério Silva', '3464-8750', 8740, '', 'rogeriosilva@grupobci.rec.br', 'S'),
(288, 'Suape', 'Engenharia', 'Luca Andrade', '2127-4350', 4429, '', 'lucaandrade@shineraydobrasil.com.br', 'S'),
(289, 'São Paulo', 'Lojas', 'Loja Shineray Electric  - Aricanduva', '', 0, '(11) 97352-4774', 'lojaaricanduvasp@shineraydobrasil.com.br', 'N'),
(290, 'Boa Viagem', 'Sala Seleção', 'Térreo', '', 8800, '', '', 'S'),
(291, 'Boa Viagem', 'Comercial Motos', 'Ana Paula Lins', '3464-8797', 8797, '98262-8640', 'analins@shineraydobrasil.com.br', 'S'),
(292, 'Suape', 'Pós Vendas/Assistência Técnica', 'Daniele Menezes', '2127-4375', 4375, '98207-0924', 'danielemenezes@shineraydobrasil.com.br', 'N'),
(293, 'Boa Viagem ', 'Comercial Motos', 'Tatiane Silva', '3464-8750', 8818, '99245-1735', 'tatianesilva@shineraydobrasil.com.br', 'S'),
(294, 'Boa Viagem', 'RH/DP', 'Alexsandra Santos', '3464-8777', 8777, '', 'alexsandrasantos@grupobci.rec.br', 'S'),
(295, 'Boa Viagem', 'Jurídico', 'Priscila Mendes', '3464-8750', 8747, '', 'priscilamendes@grupobci.rec.br', 's'),
(297, 'Boa Viagem', 'Contábil', 'Julia Oliveira', '3464-8750', 8826, '', 'juliaoliveira@grupobci.rec.br', 'S'),
(299, 'Suape', 'Centro Técnico', 'Ednardo Mariano', '2127-4348', 4430, '(81) 98191-1349', 'ednardomariano@shineraydobrasil.com.br', 'S'),
(300, 'Boa Viagem', 'Comercial / E-commerce', 'Alexandre Leão', '3464-8786', 8786, '', 'alexandreleao@shineraydobrasil.com.br', 'S'),
(301, 'Boa Viagem', 'Financeiro/Contas a Receber', 'Ketily Lima', '3464-8750', 8731, '', 'ketilylima@grupobci.rec.br', 'S'),
(302, 'Boa Viagem', 'Contábil', 'Dilza Holanda', '3464-8750', 8746, '', 'dilzaholanda@grupobci.rec.br', 'S'),
(303, 'Boa Viagem', 'Coordenadora de Negócio ', 'Aline Alves', '3464-8784', 8784, '98213-5567', 'alinealves@grupobci.rec.br', 'S'),
(4311, 'Montadora Suape', 'Centro Técnico', 'Eduarda Medeiros', '2127-4311', 4311, '98139-4145', 'eduardamedeiros@shineraydobrasil.com.br', 'S'),
(4332, 'Suape', 'Compras', 'Nosan Santos', '21274332', 4332, '', 'nosansantos@shineraydobrasil.com.br', 'N'),
(4334, 'Boa Viagem', 'Trading', 'Samuel Gillen', '3464-8750', 8728, '', 'samuelgillen@grupobci.rec.br', 'N'),
(4335, 'São Paulo', 'Lojas', 'Loja Shineray Electric  - Santo André', '', 0, '(11) 91683-8051', 'lojasantoandresp@shineraydobrasil.com.br', 'N'),
(4336, 'São Paulo', 'Lojas', 'Loja Shineray Electric  - Pacaembú', '', 0, '(11) 91683-8023', 'lojapacaembusp@shineraydobrasil.com.br', 'N'),
(4337, 'SP', 'Comercial Motos', 'Wendel Lazko', '', 0, '(11) 99723-7269', 'wendellazko@shineraydobrasil.com.br', 'S'),
(4338, 'Boa Viagem', 'Planejamento e Gestão/Controladoria  ', 'Selton Fernandes', '3464-8750', 8832, '', 'seltonfernandes@grupobci.rec.br', 'S'),
(4339, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Júlia Barbosa', '3464-8750', 8840, '', 'juliabarbosa@grupobci.rec.br', 'S'),
(4340, 'Boa Viagem', 'Fiscal', 'Maria Melo', '3464-8750', 8727, '', 'aprendiz@grupobci.rec.br', 'N'),
(4342, 'Boa Viagem', 'RH/DP', 'Maria Elena', '3464-8799', 8799, '', 'elenasouza@grupobci.rec.br', 'S'),
(4343, 'Boa Viagem', 'Financeiro/Contas a Receber  ', 'Silvania Silva', '3464-8750', 8838, '', 'silvaniasilva@grupobci.rec.br', 'S'),
(4344, 'Boa Viagem', 'Marketing', 'Vanderson Ribeiro', '3464-8750', 8836, '', 'vandersonlima@shineraydobrasil.com.br', 'S'),
(4345, 'Boa Viagem', 'Marketing', 'Heloísa Silva', '3464-8835', 8835, '', 'heloisasilva@grupobci.rec.br', 'S'),
(4346, 'Boa Viagem', 'Marketing', 'Viviane Bispo', '3464-8750', 8841, '', 'vivianebispo@shineraydobrasil.com.br ', 'S'),
(4347, 'Boa Viagem', 'Faturamento', 'Alessandro Santos', '3464-8750', 8839, '98183-5900', 'alessandroalmeida@grupobci.rec.br', 'S'),
(4350, 'São Paulo', 'Assistência Técnica', 'David Souza', '', 0, '(11) 99526-3000', 'davidsouza@shineraydobrasil.com.br', 'S'),
(4351, 'Imbiribeira', 'Top Locações', 'Paulo Cardozo', '3464-8750', 8849, '98244-7730', 'paulocardozo@toplocacoes.rec.br', 'S'),
(4352, 'Boa Viagem', 'Faturamento/Fiscal', 'Ronaldo Silva', '3464-8750', 8748, '', 'ronaldosilva@grupobci.rec.br', 'S'),
(4354, 'Boa Viagem', 'Fiscal/Faturamento', 'Lucas Zloccowick', '3464-8750', 8848, '', 'lucaszloccowick@grupobci.rec.br', 'S'),
(4355, 'Boa Viagem', 'Combustível', 'Gleidson Sousa', '3464-8750', 8810, '', 'gleidsonsousa@grupobci.rec.br', 'N'),
(4356, 'Boa Viagem', 'Combustível', 'Aline Ferreira', '3464-8750', 8810, '97104-9570\n\n', 'alineferreira@grupobci.rec.br', 'N'),
(4357, 'Boa Viagem', 'Engenharia', 'Anderson Santos', '3464-8750', 8837, '(81) 98230-3884', 'andersonsantos@bceiconstrutora.rec.br', 'S'),
(4360, 'Boa Viagem', 'Fiscal', 'Isamira Menezes', '3464-8750', 8842, '', 'isamiramenezes@grupobci.rec.br', 'S'),
(4361, 'Boa Viagem', 'Combustível', 'Lorena Ferreira ', '3464-8750', 8844, '(81) 98788-9750', 'lorenaferreira@grupobci.rec.br', 's'),
(4363, 'Boa Viagem', 'Trading', 'Juliana Silva', '3464-8750', 8845, '', 'julianasilva@grupobci.rec.br', 'S'),
(4364, 'Boa Viagem', 'Faturamento/Fiscal', 'Lucas Pontes', '3464-8750', 8801, '', 'aprendiz2@grupobci.rec.br', 'S'),
(4365, 'Boa Viagem', 'Comercial Motos', 'Mariana Silva', '3464-8773', 8773, '(81) 98639-5590', 'marianasilva@shineraydobrasil.com.br', 'S'),
(4366, 'Boa Viagem', 'Combustível', 'Luiz Silva', '3464-8750', 8848, '', 'luizsilva@grupobci.rec.br', 'N'),
(4367, 'Boa Viagem', 'Fiscal', 'Izaneide Marter', '3464-8750', 8749, '', 'izaneidemarter@shineraydobrasil.com.br', 'S'),
(4368, 'Pernambuco', 'Lojas', 'Loja Top Locações', '2127-4359', 4359, '', '', 'S'),
(4369, 'Imbiribeira', 'Top Locações', 'Jonathan Ferreira', '2127-4359', 4359, '98213-9462', 'jonathanferreira@toplocacoes.rec.br', 'S'),
(4370, 'Suape', 'SAC', 'Ana Pereira', '(81) 3464-8750', 4363, '(81) 98201-5688 ', 'anapereira@shineraydobrasil.com.br', 'S'),
(4371, 'São Paulo', 'Representante Técnico', 'Arlindo Romero', '', 0, '(11) 97468-3000', 'arlindoromero@shineraydobrasil.com.br', 'N'),
(4372, 'Boa Viagem', 'Combustível', 'Jonas Silva', '3464-8750', 8852, '', 'jonassilva@grupobci.rec.br', 'S'),
(4374, 'Fortaleza', 'Lojas', 'Loja Shineray Parangaba - CE', '', 0, '(85) 98879-3463', 'lojaparangabace@shineraydobrasil.com.br', 'N'),
(4375, 'Suape', 'Engenharia', 'Ana Borges', '2127-4350', 4429, '', 'anaborges@shineraydobrasil.com.br', 'S'),
(4377, 'Suape', 'Comercial Peças', 'Bruno Moraes', '(81) 3464-8750', 4427, '(81) 99292-9964', 'brunomoraes@shineraydobrasil.com.br', 'S'),
(4378, 'Suape', 'Produção/Motos', 'Gilckerson Santos', '2127-4350', 4434, '', 'gilckersonsantos@shineraydobrasil.com.br', 'S'),
(4379, 'Suape', 'Produção/Motos', 'Heloiza Paula', '2127-4350', 4434, '', 'aprendizprodsuape@shineraydobrasil.com.br', 'n'),
(4380, 'Suape', 'Produção/Motos', 'Wanderson Melo', '2127-4350', 4434, '', 'wandersonmelo@shineraydobrasil.com.br', 'S'),
(4381, 'Suape', 'Operações/Logística', 'Pedro Silva', '2127-4373', 4373, '', 'logisticasuape@shineraydobrasil.com.br', 'S'),
(4382, 'Suape', 'Operações/Logística', 'Manoel Neto', '2127-4377', 4377, '98685-3179', 'manoelneto@shineraydobrasil.com.br', 'S'),
(4383, 'Suape', 'Operações/Logística', 'Gustavo Júnio', '2127-4380', 4380, '', 'aprendizlogsuape@shineraydobrasil.com.br', 'S'),
(4384, 'Suape', 'Almoxarifado Peças', 'Tiago/Ítalo/Edson ', '2127-4350', 4404, '', 'edsonnunes@shineraydobrasil.com.br\n\nalmoxpecas@shineraydobrasil.com.br', 'S'),
(4385, 'Suape', 'Almoxarifado Peças', 'Paulo Fernandes', '2127-4350', 4404, '98686-0017', 'paulofernandes@shineraydobrasil.com.br', 'S'),
(4386, 'Suape', 'Manutenção', 'Fabiano Santos', '2127-4331', 4331, '', 'fabianosantos@grupobci.rec.br', 'S'),
(4387, 'Suape', 'Comercial Peças', 'Tainá Silva', '2127-4328', 4328, '(81) 98685-6924', 'tainasilva@shineraydobrasil.com.br', 'S'),
(4388, 'Suape', 'Compras', 'Janaina Vitorino', '2127-4329', 4329, '', 'janainavitorino@shineraydobrasil.com.br', 'N'),
(4389, 'Suape', 'RH/SESMT', 'Cauã Silva', '2127-4366', 4366, '', 'aprendizsuape@grupobci.rec.br', 'S'),
(4391, 'São Paulo', 'Comercial Motos', 'Gullith Jatoba', '', 0, '(11) 99761-9626', 'gullithjatoba@shineraydobrasil.com.br', 'S'),
(4392, 'São Paulo', 'Comercial Motos', 'Lucas Losada', '', 0, '98686-0187', 'lucaslosada@shineraydobrasil.com.br', 'N'),
(4393, 'Rio de Janeiro', 'Comercial Motos', 'Victor Santo', '', 0, '98685-3516', 'victorsantos@shineraydobrasil.com.br', 'N'),
(4394, 'São Paulo', 'Comercial Peças', 'Silvio Filho', '', 0, '98685-4636', 'silviofilho@shineraydobrasil.com.br', 'N'),
(4395, 'São Paulo', 'Comercial Motos', 'André Pires', '', 0, '98685-4378', 'andrepires@shineraydobrasil.com.br', 'N'),
(4396, 'Belo Horizonte', 'Comercial Motos', 'Alysson Pinto', '', 0, '98685-4894', 'alyssonpinto@shineraydobrasil.com.br', 'N'),
(4398, 'Suape', 'ALMOXARIFADO PEÇAS', 'Marcelo Silva', '2127-4350', 4404, '99323-0465', 'marcelosilva@shineraydobrasil.com.br', 'n'),
(4400, 'Boa Viagem', 'Sala de Reunião', 'Sala 04 (2º Andar)', '', 8865, '', '', 'S'),
(4401, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Danilo Silva', '3464-8750', 8843, '', 'danilosilva@grupobci.rec.br', 'S'),
(4402, 'Suape', 'RH/SESMT', 'Otávio Neto', '2127-4375', 4375, '(81) 98249-0394', 'otavioneto@shineraydobrasil.com.br', 'S'),
(4403, 'São Paulo', 'Comercial Motos e MKT', 'Marcos Gonçalves', '', 0, '(11) 95043-0661', 'marcosgoncalves@shineraydobrasil.com.br', 'S'),
(4405, 'Suape', 'Pós-Venda', 'Milton Ribeiro', '(81) 3464-8750', 4363, '(81) 99323-3098', 'miltonribeiro@shineraydobrasil.com.br', 'S'),
(4406, 'Suape', 'Tecnologia da Informação  ', 'Jussimar Siqueira', '(81) 2127-4350	', 4406, '', 'jussimarsiqueira@grupobci.rec.br', 'N'),
(4407, 'Boa Viagem', 'Financeiro/Contas a Pagar  ', 'Maria Queiroz', '3464-8750', 0, '', 'mariaqueiroz@grupobci.rec.br', 'N'),
(4408, 'Boa Viagem', 'Financeiro/Contas a Pagar  ', 'Maria Queiroz', '3464-8750', 8870, '', 'mariaqueiroz@grupobci.rec.br', 's'),
(4409, 'Suape', 'Pós-Venda', 'Mikael Silva', '(81) 3464-8750', 4363, '(81) 99297-4401', 'mikaelsilva@shineraydobrasil.com.br', 'S'),
(4410, 'Boa Viagem', 'Pós-Venda', 'Saulo Carvalho', '3464-8750', 8812, '98685-4378', 'saulocarvalho@shineraydobrasil.com.br', 'N'),
(4411, 'Suape', 'Pós-Vendas', 'Kennedy Júnior', '(81) 3464-8750', 4363, '(81) 98553-6352', 'kennedyjunior@shineraydobrasil.com.br', 'n'),
(4412, 'Boa Viagem ', 'Comercial Motos', 'Amanda Amorim', '3464-8771', 8771, '98103-3136', 'amandaamorim@shineraydobrasil.com.br', 'S'),
(4413, 'Boa Viagem', 'Marketing', 'Danielly Vieira', '3464-8750', 8734, '', 'daniellyvieira@shineraydobrasil.com.br', 'S'),
(4414, 'Boa Viagem', 'RH/DP', 'Carolina Costa', '3464-8750', 8735, '', 'carolinacosta@shineraydobrasil.com.br', 'S'),
(4415, 'Imbiribeira', 'Top Locações', 'Amanda Oliveira', '2127-4359', 4359, '98685-4894', 'amandaoliveira@shineraydobrasil.com.br', 'S'),
(4416, 'Boa Viagem', 'Pós-Vendas', 'Kaio Moraes', '3464-8752', 8752, '(81) 99292-8957', 'kaiomoraes@shineraydobrasil.com.br', 'S'),
(4417, 'Boa Viagem', 'Comercial Veículos', 'Gleydson Ribeiro', '3464-8750', 8877, '992992952', 'gleydsonribeiro@shineraydobrasil.com.br', 'S'),
(4418, 'Boa Viagem', 'Tecnologia da Informação  ', 'Itamar Souzar', '3464-8750', 8878, '', 'itamarsouzar@grupobci.rec.br', 'S'),
(4419, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Lorena Câmara', '3464-8750', 8881, '', 'lorenacamara@grupobci.rec.br', 'N'),
(4420, 'Boa Viagem', 'Comercial Motos', 'Ranielle Silva', '3464-8750', 8847, '985536092', 'raniellesilva@shineraydobrasil.com.br', 'S'),
(4421, 'Boa Viagem', 'Comercial Veículos', 'Ricardo Menelau', '3464-8750', 8804, '994084889', 'ricardomenelau@shineraydobrasil.com.br', 'S'),
(4422, 'Suape', 'Engenharia', 'Isaac Lins', '', 0, '98553-7908', 'isaaclins@shineraydobrasil.com.br', 'S'),
(4423, 'Boa Viagem', 'Tecnologia da Informação', 'Salviano Neto', '3464-8775', 8775, '993228741', 'salvianoporto@grupobci.rec.br', 'N'),
(4424, 'Boa Viagem', 'Fiscal', 'Oscar Neto', '3464-8750', 8884, '', 'oscarneto@grupobci.rec.br', 'S'),
(4425, 'Boa Viagem', 'Comercial Veículos', 'Caroline Santos', '3464-8750', 8807, '994084889', 'carolinesantos@shineraydobrasil.com.br', 'S'),
(4426, 'Suape', 'Oficina', 'Adalberto Perez', '21274353', 4430, '', 'adalbertoperez@shineraydobrasil.com.br', 'S'),
(4427, 'Suape', 'Engenharia', 'Emanuel Ramos', '21274350', 4428, '(81) 98121-1080', 'emanuelramos@shineraydobrasil.com.br', 'S'),
(4428, 'Boa Viagem', 'Trading', 'Aricia Dutra', '3464-8750', 8885, '', 'ariciadutra@grupobci.rec.br', 'S'),
(4429, 'Suape', 'SAC', 'Tais Moraes', '(81) 3464-8750', 4363, '(81) 98687-1207', 'taismoraes@shineraydobrasil.com.br', 'S'),
(4430, 'Boa Viagem', 'Marketing', 'Thaina Santana', '3464-8750', 8730, '', 'thainasantana@shineraydobrasil.com.br', 'N'),
(4431, 'Boa Viagem', 'Tecnologia da Informação  ', 'Esdras Silva', '3464-8750', 8880, '', 'esdrassilva@grupobci.rec.br', 'S'),
(4432, 'Boa Viagem', 'Faturamento/Fiscal', 'Maria Santos', '3464-8750', 8831, '', 'mariasantos@shineraydobrasil.com.br', 'S'),
(4434, 'Boa Viagem', 'Faturamento/Fiscal', 'Vera Silva', '3464-8750', 8727, '', 'verasilva@grupobci.rec.br', 'S'),
(4435, 'Boa Viagem', 'Marketing', 'Lucas Santos', '3464-8750', 8849, '', 'lucassantos@shineraydobrasil.com.br', 'S'),
(4436, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Alexsandra Farias', '3464-8750', 8821, '', 'alexsandrafarias@grupobci.rec.br', 'S'),
(4437, 'Boa Viagem', 'Combustível', 'Bruna Ferreira', '3464-8750', 8810, '', 'brunaferreira@grupobci.rec.br', 'S'),
(4438, 'Boa Viagem', 'Faturamento/Fiscal', 'Maria Silva', '3464-8750', 8727, '', 'mariasilva@grupobci.rec.br', 'S'),
(4439, 'Suape', 'Administrativo', 'Vinicius Costa', '2127-4332', 4332, '99159-2242', 'viniciuscosta@grupobci.rec.br', 'S'),
(4440, 'Boa Viagem', 'Fiscal', 'Flávio Silva', '3464-8750', 8736, '', 'flaviosilva@grupobci.rec.br', 'S'),
(4441, 'Boa Viagem', 'Fiscal', 'Ingrid Silva', '3464-8750', 8801, '', 'ingridsilva@grupobci.rec.br', 'S'),
(4442, 'Boa Viagem', 'Comercial Motos', 'Laura Costa', '3464-8773', 8890, '(81) 98553-7496', 'lauracosta@shineraydobrasil.com.br', 'S'),
(4443, 'Boa Viagem', 'RH/DP', 'Cinthia Silva', '3464-8750', 8851, '99323-0749', 'cinthiasilva@grupobci.rec.br', 'S'),
(4444, 'Boa Viagem', 'Contábil', 'Matheus Costa', '3464-8767', 8767, '', 'matheuscosta@grupobci.rec.br', 'S'),
(4445, 'Suape', 'Pós-Vendas', 'Ryan Santos ', '(81) 3464-8750', 4363, '(81) 98686-7987', 'ryansantos@shineraydobrasil.com.br', 'S'),
(4446, 'Suape', 'Pós-Vendas', 'Willyams Silva', '(81) 3464-8750', 4363, '(81) 98629-6921', 'willyamssilva@shineraydobrasil.com.br', 'S'),
(4447, 'Suape', 'RH/SESMT', 'Felipe Dantas ', '2127-4350', 4426, '', 'felipedantas@shineraydobrasil.com.br', 'S'),
(4448, 'Boa Viagem', 'Marketing', 'Tatiana Araujo', '(81) 3464-8750', 8730, '(81) 98639-5395', 'tatianaaraujo@shineraydobrasil.com.br', 'S'),
(4449, 'Boa Viagem ', 'Marketing', 'Laryssa Silva', '3464-8750', 8891, '', 'laryssasilva@shineraydobrasil.com.br', 'S'),
(4450, 'Suape', 'Almoxarifado Peças', 'Augusto Marques', '2127-4350', 4404, '(81) 99323-3073', 'augustomarques@shineraydobrasil.com.br', 'S'),
(4451, 'Suape', 'Almoxarifado Peças', 'Carlos Olegario', '2127-4350', 4404, '98686-0017', 'carlosolegario@shineraydobrasil.com.br', 'S'),
(4452, 'Suape', 'Centro Tecnico', 'Carlos Silva', '2127-4350', 4430, '', 'carlossilva@shineraydobrasil.com.br', 'S'),
(4453, 'Boa Viagem', 'Comercial Veículos', 'Walysson Silva ', '3464-8750', 8789, '(81) 98791-9921', 'walyssonsilva@shineraydobrasil.com.br', 'S'),
(4454, 'Boa Viagem', 'Trading', 'Alan Gomes', '3464-8750', 8892, '', 'alangomes@grupobci.rec.br', 'S'),
(4455, 'Boa Viagem', 'Planejamento e Gestão/Controladoria', 'Gabriel/Williany', '3464-8750', 8893, '', 'willianysilva@grupobci.rec.br\n\ngabrielsantos@grupobci.rec.br', 'S'),
(4456, 'Suape', 'Comercial Peças', 'Hudson Santana', '2127-4350', 4329, '', 'hudsonsantana@shineraydobrasil.com.br', 'S'),
(4457, 'Boa Viagem', 'Tecnologia da Informação', 'Derinaldo Santana', '3464-8758', 8886, '', 'derinaldosantana@grupobci.rec.br', 'S'),
(4458, 'Boa Viagem', 'Engenharia', 'João Lima', '3464-8750', 8882, '', 'joaolima@grupobci.rec.br', 'S'),
(4459, 'Suape', 'Administrativo', 'Aloisio Neto', '2127-4350', 4432, '99159-2242', 'aloisioneto@shineraydobrasil.com.br', 'S'),
(4460, 'Suape', 'Logística', 'Emir Neto ', '2127-4350', 4331, '', 'emirneto@shineraydobrasil.com.br', 'S'),
(4461, 'Suape', 'Almoxarifado Peças', 'Ester Ferreira', '2127-4350', 4307, '', 'esterferreira@shineraydobrasil.com.br', 'S'),
(4462, 'Suape', 'Centro Técnico', 'Guilherme Goes', '2127-4350', 4429, '', 'guilhermegoes@shineraydobrasil.com.br', 'S'),
(4463, 'Suape', 'Centro Técnico', 'Italo Silva', '2127-4350', 4430, '', 'italosilva@shineraydobrasil.com.br', 'S'),
(4464, 'Suape', 'Operações/Logística', 'Jairo Silva', '2127-4380', 4380, '99299-9753', 'jairosilva@grupobci.rec.br', 'S'),
(4465, 'Suape', 'Operações/Logística', 'Jeferson Ribeiro', '2127-4350', 4424, '', 'jefersonribeiro@shineraydobrasil.com.br', 'S'),
(4466, 'Suape', 'Tecnologia da Informação', 'José Santos', '2127-4358', 4390, '', 'aprendiztisuape@shineraydobrasil.com.br', 'S'),
(4467, 'Suape', 'Almoxarifado Peças', 'Tiago/Ítalo/Edson ', '2127-4350', 4404, '', 'juliocesar@shineraydobrasil.com.br\n\n', 'S'),
(4468, 'Suape', 'Centro Técnico', 'Everton/Jamile', '2127-4350', 4430, '', 'aprendiztecnico@shineraydobrasil.com.br', 'S'),
(4469, 'Suape', 'Produção/Motos', 'Maira Lima', '2127-4350', 4434, '', 'mairalima@shineraydobrasil.com.br', 'S'),
(4470, 'Suape', 'Produção/Motos', 'Maria Oliveira', '2127-4364', 4364, '', 'mariaoliveira@shineraydobrasil.com.br', 'S'),
(4471, 'Suape', 'Almoxarifado Peças', 'Tiago/Ítalo/Edson/Raisa', '2127-4350', 4404, '', 'edsonnunes@shineraydobrasil.com.br\n\nalmoxpecas@shineraydobrasil.com.br', 'S'),
(4472, 'Boa Viagem', 'Engenharia', 'Allyson Menelau', '3464-8750', 8882, '', 'allysonmenelau@grupobci.rec.br', 'S'),
(4473, 'Boa Viagem', 'Comercial Motos', 'Júlio Neto', '3464-8762', 8762, '98863-6143', 'julioneto@shineraydobrasil.com.br', 'S'),
(4474, 'Suape', 'Tecnologia da Informação', 'Clécio Bezerra', '2127-4360', 4406, '', 'cleciobezerra@shineraydobrasil.com.br', 'S'),
(4475, 'Boa Viagem', 'Combustível', 'Wesley Lima', '3464-8750', 8894, '', 'wesleylima@grupobci.rec.br', 'S'),
(4476, 'Boa Viagem', 'Combustível', 'Driellson Silva', '3464-8783', 8783, '(81) 99323-3440', 'driellsonsilva@grupobci.rec.br', 'S'),
(4477, 'Boa Viagem', 'Tecnologia da Informação  ', 'José Rodrigues', '3464-8750', 8871, '', 'joserodrigues@grupobci.rec.br', 'S'),
(4478, 'Boa Viagem', 'Tecnologia da Informação', 'Mariana Lima', '3464-8776', 8775, '', 'marianalima@grupobci.rec.br', 'S'),
(4479, 'SUAPE', 'COMERCIAL', '', '812127-4350', 4435, '', '', 'S'),
(4480, 'Boa Viagem', 'Sala de Reunião', 'Sala 03 (1º Andar)', '', 8895, '', '', 'S'),
(4481, 'Boa Viagem', 'Administrativo', 'Júlia Souto', '3464-8750', 8883, '', 'juliasouto@grupobci.rec.br', 'S'),
(4482, 'Suape', 'Pós Vendas', 'Ana Rosa Pereira', '3464-8750', 4435, '98201-5688', 'anapereira@shineraydobrasil.com.br', 'S'),
(4483, 'Boa Viagem', 'Frota', 'Levi Tavares', '3464-8750', 8887, '', 'levitavares@grupobci.rec.br', 'S'),
(4484, 'Boa Viagem', 'Combustível', 'Luís Machado', '(81) 3464-8750', 8872, '', 'luismachado@grupobci.rec.br', 'S'),
(4505, 'teste', 'teste', 'teste', '123', 43434, '234234', 'fsdfsd@fdssdf.com', 'N'),
(4508, '4444', '44', '44', '44', 44, '4', '4', '4'),
(4509, '22222', '2222', '222222222222222222222222222222222', '2222', 222, '222', '2222', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_role`
--

CREATE TABLE `tb_role` (
  `id_role` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cod_role` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_role`
--

INSERT INTO `tb_role` (`id_role`, `name`, `cod_role`, `created_at`) VALUES
(24, 'Manutenção', '', '2026-01-23 16:38:14'),
(42, 'Qualidade', '', '2026-01-23 16:38:05'),
(58, 'Engenharia', '', '2026-01-23 16:37:54'),
(87, 'TI', '', '2026-01-23 16:37:37'),
(88, 'Diretoria', '', '2026-01-23 16:37:43'),
(89, 'Compras', '', '2026-01-23 16:38:29'),
(90, 'Comercial peças', '', '2026-01-23 16:38:36'),
(91, 'Almoxarifado', '', '2026-01-23 16:38:42'),
(92, 'Logística / Expedição', '', '2026-01-23 16:38:57'),
(93, 'Comexport', '', '2026-01-23 16:39:04'),
(94, 'Tagman', '', '2026-01-23 16:39:08'),
(95, 'Linha de produção', '', '2026-01-23 16:39:14'),
(96, 'Refeitório', '', '2026-01-23 16:39:22'),
(97, 'Segurança do trabalho', '', '2026-01-23 16:39:37'),
(98, 'Marketing', '', '2026-02-03 16:05:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_subscriptions`
--

CREATE TABLE `tb_subscriptions` (
  `id_subscription` int(11) NOT NULL,
  `cod_subscription` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name_color` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `url_slug` varchar(264) NOT NULL,
  `subscription_active` tinyint(4) NOT NULL,
  `id_user` int(11) NOT NULL,
  `dt_subscription` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_subscriptions`
--

INSERT INTO `tb_subscriptions` (`id_subscription`, `cod_subscription`, `name`, `name_color`, `description`, `url_slug`, `subscription_active`, `id_user`, `dt_subscription`) VALUES
(10, '', 'Modelo Shineray do Brasil', '#e30613', '', 'modelo-shineray-do-brasil', 1, 17, '2026-02-08 11:53:33'),
(12, '', 'Modelo BCI', '#183e7a', '', 'modelo-bci', 1, 17, '2026-02-08 11:48:42'),
(13, '', 'Modelo Shineray do Brasil 2', '#e30613', '', 'modelo-shineray-do-brasil-2', 1, 17, '2026-02-08 11:33:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_units`
--

CREATE TABLE `tb_units` (
  `id_unit` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cod_unit` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_units`
--

INSERT INTO `tb_units` (`id_unit`, `name`, `cod_unit`, `created_at`) VALUES
(1, 'Grupo BCI Boa Viagem', '', '2026-02-06 12:21:13'),
(2, 'Grupo BCI Cabo', '', '2026-02-06 12:20:57'),
(3, 'Grupo BCI escritório Shineray', '', '2026-02-06 12:20:44'),
(7, 'Shineray do Brasil', '', '2026-02-06 12:20:10'),
(10, 'Shineray do Brasil - Imbiribeira', '', '2026-02-06 12:19:38'),
(12, 'Shineray do Brasil - Outlet', '', '2026-02-06 12:19:59'),
(14, 'Shineray do Brasil - São Paulo', '', '2026-02-06 12:12:44'),
(16, '34234', '234', '2026-02-06 13:11:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `desname` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `setor` varchar(60) NOT NULL,
  `inadmin` tinyint(2) NOT NULL,
  `user_active` tinyint(4) NOT NULL,
  `data_usuario` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `desname`, `login`, `senha`, `setor`, `inadmin`, `user_active`, `data_usuario`) VALUES
(17, 'Clécio Lins Bezerra', 'cleciobezerra', '$2y$12$gcl.9GUN2v0ZC/OYthUCwukRfQjlgUq2dnoaXbS8WywNllQix0coq', 'TI', 0, 1, '2020-01-24 08:34:01'),
(30, 'Administrador', 'admin', '$2y$12$F.TrAMzbyEMroUqGX/DIWOF32Uk5YKSIF90DVIzjG4pX6nkTF1NLK', 'Qualidade', 2, 1, '2021-06-22 15:58:09'),
(44, 'clecio', '123', '$2y$12$QaKcQ3Mvxx6ennlV6PABa.7W3bpOnJ6/dJuv.axrAVoe5ahsJMQGW', 'Qualidade', 2, 1, '2026-01-29 09:38:46'),
(56, '123', '123', '$2y$12$PqDThXVmhfqdHT0eYljKYuRCbagnF9GgB8q3bt/RlSgqzu/5Rh.wK', 'Diretoria', 0, 1, '2026-02-07 10:04:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_alert`
--
ALTER TABLE `tb_alert`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_birthdays`
--
ALTER TABLE `tb_birthdays`
  ADD PRIMARY KEY (`id_birthday`);

--
-- Índices para tabela `tb_class_occs`
--
ALTER TABLE `tb_class_occs`
  ADD PRIMARY KEY (`id_class_occ`);

--
-- Índices para tabela `tb_conclusions`
--
ALTER TABLE `tb_conclusions`
  ADD PRIMARY KEY (`id_conclusion`);

--
-- Índices para tabela `tb_convenants`
--
ALTER TABLE `tb_convenants`
  ADD PRIMARY KEY (`id_convenant`),
  ADD KEY `FK__tb_users` (`id_user`);

--
-- Índices para tabela `tb_degree_damgs`
--
ALTER TABLE `tb_degree_damgs`
  ADD PRIMARY KEY (`id_degree_damg`);

--
-- Índices para tabela `tb_departments`
--
ALTER TABLE `tb_departments`
  ADD PRIMARY KEY (`id_department`);

--
-- Índices para tabela `tb_events`
--
ALTER TABLE `tb_events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `FKid_user` (`id_user`);

--
-- Índices para tabela `tb_factoccurreds`
--
ALTER TABLE `tb_factoccurreds`
  ADD PRIMARY KEY (`id_factoccurred`);

--
-- Índices para tabela `tb_file`
--
ALTER TABLE `tb_file`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `FK_tb_photos_tb_events` (`id_notificacao`);

--
-- Índices para tabela `tb_incidents`
--
ALTER TABLE `tb_incidents`
  ADD PRIMARY KEY (`id_incident`);

--
-- Índices para tabela `tb_internacionalsecuritys`
--
ALTER TABLE `tb_internacionalsecuritys`
  ADD PRIMARY KEY (`id_internacionalsecurity`);

--
-- Índices para tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  ADD PRIMARY KEY (`id_notificacao`);

--
-- Índices para tabela `tb_occurrences`
--
ALTER TABLE `tb_occurrences`
  ADD PRIMARY KEY (`id_occurrence`);

--
-- Índices para tabela `tb_patientsecuritys`
--
ALTER TABLE `tb_patientsecuritys`
  ADD PRIMARY KEY (`id_patientsecurity`);

--
-- Índices para tabela `tb_photos`
--
ALTER TABLE `tb_photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_tb_photos_tb_events` (`id_event`);

--
-- Índices para tabela `tb_photospost`
--
ALTER TABLE `tb_photospost`
  ADD PRIMARY KEY (`id_photo`);

--
-- Índices para tabela `tb_photosuser`
--
ALTER TABLE `tb_photosuser`
  ADD PRIMARY KEY (`id_photo`);

--
-- Índices para tabela `tb_popups`
--
ALTER TABLE `tb_popups`
  ADD PRIMARY KEY (`id_popup`),
  ADD KEY `FK_tb_users_tb_popups_idx` (`id_user`);

--
-- Índices para tabela `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `FK_tb_users_tb_posts_idx` (`id_user`);

--
-- Índices para tabela `tb_problems`
--
ALTER TABLE `tb_problems`
  ADD PRIMARY KEY (`id_problem`);

--
-- Índices para tabela `tb_processs`
--
ALTER TABLE `tb_processs`
  ADD PRIMARY KEY (`id_process`);

--
-- Índices para tabela `tb_ramais`
--
ALTER TABLE `tb_ramais`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Índices para tabela `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Índices para tabela `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  ADD PRIMARY KEY (`id_subscription`);

--
-- Índices para tabela `tb_units`
--
ALTER TABLE `tb_units`
  ADD PRIMARY KEY (`id_unit`);

--
-- Índices para tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_birthdays`
--
ALTER TABLE `tb_birthdays`
  MODIFY `id_birthday` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de tabela `tb_conclusions`
--
ALTER TABLE `tb_conclusions`
  MODIFY `id_conclusion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_convenants`
--
ALTER TABLE `tb_convenants`
  MODIFY `id_convenant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `tb_degree_damgs`
--
ALTER TABLE `tb_degree_damgs`
  MODIFY `id_degree_damg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_departments`
--
ALTER TABLE `tb_departments`
  MODIFY `id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de tabela `tb_events`
--
ALTER TABLE `tb_events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT de tabela `tb_factoccurreds`
--
ALTER TABLE `tb_factoccurreds`
  MODIFY `id_factoccurred` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de tabela `tb_file`
--
ALTER TABLE `tb_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_incidents`
--
ALTER TABLE `tb_incidents`
  MODIFY `id_incident` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_internacionalsecuritys`
--
ALTER TABLE `tb_internacionalsecuritys`
  MODIFY `id_internacionalsecurity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_notificacao`
--
ALTER TABLE `tb_notificacao`
  MODIFY `id_notificacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30922525;

--
-- AUTO_INCREMENT de tabela `tb_occurrences`
--
ALTER TABLE `tb_occurrences`
  MODIFY `id_occurrence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `tb_patientsecuritys`
--
ALTER TABLE `tb_patientsecuritys`
  MODIFY `id_patientsecurity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_photos`
--
ALTER TABLE `tb_photos`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2442;

--
-- AUTO_INCREMENT de tabela `tb_popups`
--
ALTER TABLE `tb_popups`
  MODIFY `id_popup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `tb_posts`
--
ALTER TABLE `tb_posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=853;

--
-- AUTO_INCREMENT de tabela `tb_problems`
--
ALTER TABLE `tb_problems`
  MODIFY `id_problem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_processs`
--
ALTER TABLE `tb_processs`
  MODIFY `id_process` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tb_ramais`
--
ALTER TABLE `tb_ramais`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4510;

--
-- AUTO_INCREMENT de tabela `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  MODIFY `id_subscription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `tb_units`
--
ALTER TABLE `tb_units`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
