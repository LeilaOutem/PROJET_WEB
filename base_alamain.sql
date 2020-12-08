-- DROP DATABASE
-- DROP DATABASE if exists annotgenome;

-- DATABASE CREATION
-- CREATE DATABASE annotgenome CHARACTER SET utf8 COLLATE utf8_general_ci;

-- SET DATABASE
-- \c annotgenome; 


-- ROLES
CREATE TABLE role(id_role SERIAL PRIMARY KEY NOT NULL, 
descriptor VARCHAR(32) CHECK (descriptor IN ('administrator', 'user', 'validator', 'annotator')) ,
			code VARCHAR(8) CHECK (code IN ('admin', 'u', 'valid', 'annot') ));

-- FILL IN THE ROLES LIST
INSERT INTO role(descriptor,code) VALUES
('administrator', 'admin'),
('user', 'u'),
('validator', 'valid'),
('annotator', 'annot');

-- USERS
CREATE TABLE users(id_user SERIAL PRIMARY KEY NOT NULL,
email VARCHAR(64) UNIQUE NOT NULL,
password VARCHAR(128) NOT NULL,
first_name varchar(32) NOT NULL,
surname varchar(32) NOT NULL,
phone_number varchar(32) UNIQUE,
date_last_connexion Date,
inscription_status boolean DEFAULT false,
id_role int NOT NULL,
CONSTRAINT FKseq_id_role FOREIGN KEY (id_role) REFERENCES role(id_role));

-- GENOME
CREATE TABLE genome(id_genome SERIAL PRIMARY KEY NOT NULL,
genome_sequence text,
length INT,
chromosome VARCHAR(32),
species_name VARCHAR(32),
strain VARCHAR(32));

-- SEQUENCE
CREATE TABLE sequence(id_sequence VARCHAR(32) PRIMARY KEY NOT NULL, 
nt_sequence VARCHAR(1024), prot_sequence VARCHAR(1024), 
chromosome VARCHAR(32), start_pos INT, end_pos INT, length INT, 
id_genome INT, 
status VARCHAR(64) CHECK(status IN ('not annotated', 'waiting for annotation', 'annotated, waiting for validation', 'validated')), 
CONSTRAINT FKseq_id_genome FOREIGN KEY (id_genome) REFERENCES genome(id_genome));

-- ANNOTATION
CREATE TABLE annotation(id_sequence VARCHAR(32) PRIMARY KEY NOT NULL, 
				gene VARCHAR(32), 
				gene_biotype VARCHAR(128), 
				transcript_biotype VARCHAR(128), 
				gene_symbol VARCHAR(8), 
				description VARCHAR(128), 
				validator_comment VARCHAR(256), 
				CONSTRAINT FKannot_id_sequence FOREIGN KEY (id_sequence) REFERENCES sequence(id_sequence));

-- ASSIGNATION
CREATE TABLE assignation_sequence(id_annotateur INT, id_validateur INT, 
id_sequence VARCHAR(32), PRIMARY KEY (id_validateur, id_annotateur, id_sequence), 
CONSTRAINT FKasq_id_validateur FOREIGN KEY(id_validateur) REFERENCES users(id_user), 
CONSTRAINT FKasq_id_annotateur FOREIGN KEY(id_annotateur) REFERENCES users(id_user), 
CONSTRAINT FKasq_id_sequence FOREIGN KEY (id_sequence) REFERENCES sequence(id_sequence));
	
