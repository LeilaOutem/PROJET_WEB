#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Dec 10 19:28:51 2020

@author: freaky
"""

import psycopg2

from parse_functions import *

# infos pour se connecter à la BD

def insert_annotated(genome_dir):
    try:
        #params = config()
        conn = psycopg2.connect(host="localhost",database="annotgenome",user="freaky",password="") #,port = "1")
        cur = conn.cursor()
        # Début de transaction
        # cur.execute(requete)
        genome_attribute = parse_genome(genome_dir)
        # table (genome_sequence, length, chromosome, species_name, strain)
        insert_genome_query = f"INSERT INTO genome (genome_sequence, length, chromosome, species_name, strain) VALUES ({genome_attribute[0]}, {genome_attribute[1]}, {genome_attribute[2]}, {genome_attribute[3]}, {genome_attribute[4]}) RETURNING id_genome;"
        print(genome_dir + " inséré dans la base")
        cur.execute(insert_genome_query)

        id_genome = cur.fetchone()[0]

        sequence_attribute_list = parse_sequence(genome_dir) #, id_genome)
        for seq_att in sequence_attribute_list:
            # table : (id_sequence, nt_sequence, prot_sequence, chromosome, start_pos, end_pos, length, id_genome)
            # id_sequence = sequence_attribute[0]
            # nt_sequence = sequence_attribute[1]
            # prot_sequence = sequence_attribute[2]
            # chromosome = sequence_attribute[3]
            # start_pos = sequence_attribute[4]
            # end_pos = sequence_attribute[5]
            # length = sequence_attribute[6]
            insert_sequence_query = f"INSERT INTO sequence (id_sequence, nt_sequence, prot_sequence, chromosome, start_pos, end_pos, length, id_genome, status) VALUES ({seq_att[0]}, {seq_att[1]}', {seq_att[2]}', {seq_att[3]}, {seq_att[4]},{seq_att[5]}, {seq_att[6]}, {id_genome}, 'validated');"
            cur.execute(insert_sequence_query)

        annotation_attribute_list = parse_annotation(genome_dir) #, id_genome)
        for annot_att in annotation_attribute_list:
            # table : (id_sequence, gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment)
            # id_sequence = annotation_attribute[0]
            # gene = annotation_attribute[1]
            # gene_biotype = annotation_attribute[2]
            # transcript_biotype = annotation_attribute[3]
            # gene_symbol = annotation_attribute[4]
            # description = annotation_attribute[5]
            # validator_comment = annotation_attribute[6]annot_att
            insert_sequence_query = f"INSERT INTO annotation (id_sequence, strand, gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment) VALUES ({annot_att[0]}, {annot_att[1]}, {annot_att[2]}, {annot_att[3]}, {annot_att[4]}, {annot_att[5]}, {annot_att[6]}, {annot_att[7]});"
            cur.execute(insert_sequence_query)
        # commit changes
        conn.commit()
    except psycopg2.DatabaseError as error:
        print(error)

def insert_not_annoted(genome_dir):
    try:
        #params = config()
        conn = psycopg2.connect(host="localhost",database="annotgenome",user="freaky",password="") #,port = "1")
        cur = conn.cursor()
        # Début de transaction
        # cur.execute(requete)
        genome_attribute = parse_genome(genome_dir)
        # table (genome_sequence, length, chromosome, species_name, strain)
        insert_genome_query = f"INSERT INTO genome (genome_sequence, length, chromosome, species_name, strain) VALUES ({genome_attribute[0]}, {genome_attribute[1]}, {genome_attribute[2]}, {genome_attribute[3]}, {genome_attribute[4]}) RETURNING id_genome;"
        print(genome_dir + " inséré dans la base")
        cur.execute(insert_genome_query)

        id_genome = cur.fetchone()[0]

        sequence_attribute_list = parse_sequence(genome_dir) #, id_genome)
        for seq_att in sequence_attribute_list:
            # table : (id_sequence, nt_sequence, prot_sequence, chromosome, start_pos, end_pos, length, id_genome)
            # id_sequence = sequence_attribute[0]
            # nt_sequence = sequence_attribute[1]
            # prot_sequence = sequence_attribute[2]
            # chromosome = sequence_attribute[3]
            # start_pos = sequence_attribute[4]
            # end_pos = sequence_attribute[5]
            # length = sequence_attribute[6]
            insert_sequence_query = f"INSERT INTO sequence (id_sequence, nt_sequence, prot_sequence, chromosome, start_pos, end_pos, length, id_genome, status) VALUES ({seq_att[0]}, {seq_att[1]}', {seq_att[2]}', {seq_att[3]}, {seq_att[4]},{seq_att[5]}, {seq_att[6]}, {id_genome}, 'not annotated');"
            cur.execute(insert_sequence_query)

        # commit changes
        conn.commit()
    except psycopg2.DatabaseError as error:
        print(error)


if __name__ == "__main__":
    directory = ""
    annotated = ("Escherichia_coli_cft073", "Escherichia_coli_o157_h7_str_edl933", "Escherichia_coli_str_k_12_substr_mg1655")
    not_annoted = "new_coli"

    for genome in annotated:
        insert_annotated(directory + genome)

    insert_not_annoted(directory + not_annoted)
