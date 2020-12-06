from parser_to_sql_functions import *

directory = "data//"

already_annoted_genomes = ["Escherichia_coli_cft073", "Escherichia_coli_o157_h7_str_edl933", "Escherichia_coli_str_k_12_substr_mg1655"]
not_annoted_genome = ["new_coli"]

i = 1
# utilisation une variable i à cause de l'auto incrément pour les clés primaires dans la table génome
for genome in already_annoted_genomes:
    parse_annot(directory + genome, i)
    i = i+1

for genome in not_annoted_genome:
    parse_not_annot(directory + genome, i)
    i = i+1
