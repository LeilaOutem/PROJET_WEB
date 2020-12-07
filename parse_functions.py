def parse_genome(genome_dir):
    # retourne une liste des attributs à INSERT dans la table SQL Génome pour un génome
    directory = "/".join(genome_dir.split("/")[0:-1])
    genome = genome_dir.split("/")[-1]

    insert_file = open("insert_values_" + genome + ".sql", "w")

    dict_seq = dict()

    species_name = "_".join(genome.split("_")[0:2])
    strain = "_".join(genome.split("_")[2:])

    with open(directory + genome + ".fa", "r") as f:
        genome_file = f.readlines()

    genome_sequence = ""

    for line in genome_file:
        if ">" in line:
            info = line.split(":")
            chromosome = info[2]
            length = info[5]
    
        else:
            line = line.strip()
            genome_sequence = genome_sequence + line
    
    return([genome_sequence, length, chromosome, species_name, strain])

def parse_sequence(genome_dir):
    # retourne une liste des attributs à INSERT dans la table SQL Séquence pour un génome
    # Chaque élement de la liste est sous la forme :
    # [id_sequence, nt_sequence, prot_sequence, chromosome, start_pos, end_pos, length, id_genome]

    # l'attribut STATUT à definir soit même dans la requete !

    # CREATE TABLE sequence(id_sequence : VARCHAR(32) PRIMARY KEY NOT NULL,
    #                     nt_sequence : VARCHAR(1024), 
    #                     prot_sequence : VARCHAR(1024), 
    #                     chromosome : VARCHAR(32),
    #                     start_pos : INT, end_pos : INT, length : INT, 
    #                     status : VARCHAR(64) CHECK(status IN
    #                     (‘not annotated’, ‘waiting for annotation’,  ‘annotated, waiting 
    #                     for validation’, ‘validated’)), 
    #                     CONSTRAINT FKseq_id_genome FOREIGN KEY 
    #                     (id_genome) REFERENCES genome(id_genome), 
    #                     CONSTRAINT FKseq_id_user FOREIGN KEY id_user 
    #                     REFERENCES user (id_user))

    sequences = []

    directory = "/".join(genome_dir.split("/")[0:-1])
    genome = genome_dir.split("/")[-1]

    with open(directory + genome + "_cds.fa") as f:
            cds_file = f.readlines()

    dict_seq = dict()
    for line in cds_file:
        if ">" in line:
            # On divise la ligne d'info '>' en liste pour obtenir les différentes catégories
            info = line.strip().split(" ")
            # Problème avec .split(" "), les différentes catégories sont séparées par des " "
            # Il y a aussi des " " entre les différents mot dans la catégorie "description"
            # donc .split(" ") donne :
            # [..., 'description:Probable', 'transport', 'ATP-binding', 'protein', 'msbA']
            # alors qu'on voudrait :
            # [..., 'description:Probable transport ATP-binding protein msbA']
            for i, item in enumerate(info):
                if "description:" in item:
                    # En énumérant la liste, quand on arrive à l'élement qui contient "description:"
                    # On grèffe tous les éléments suivants de la liste à la suite avec .join()
                    info[i] = " ".join(info[i:])
                    # Puis on enleve la partie de la liste contenant les éléments qu'on a déjà récupéré
                    info = info[:i+1]

            # Extraire les élements d'annotations pour les ajouter au dictionnaire
            id_sequence = info[0].split(">")[1]
            dict_seq[id_sequence] = dict()
            
            # clé étrangère pour le génome

            info_position = info[2].split(":")
            dict_seq[id_sequence]["chromosome"] = info_position[1]
            dict_seq[id_sequence]["start_pos"] = info_position[3]
            dict_seq[id_sequence]["end_pos"] = info_position[4]
            dict_seq[id_sequence]["length"] = str(int(info_position[4]) - int(info_position[3]))
            dict_seq[id_sequence]["strand"] = info_position[5]

            # On commence une nouvelle séquence
            dict_seq[id_sequence]["nt_sequence"] = ""

        else:
            # On concatène les lignes ensemble pour former la séquence en une seule chaine de caractères
            # jusqu'à trouver un nouveau '>'
            line = line.strip()
            dict_seq[id_sequence]["nt_sequence"] += line


    # On lit le fichier _pep.fa pour récuperer la séquence peptidique 
    with open(directory + genome + "_pep.fa") as f:
        pep_file = f.readlines()

    for line in pep_file:
        if ">" in line:
            id_sequence = line.split(" ")[0].split(">")[1]
            dict_seq[id_sequence]["prot_sequence"] = ""

        else:
            line = line.strip()
            dict_seq[id_sequence]["prot_sequence"] += line


    sequence_list = list()
    for id in dict_seq:
        sequence = list()
        sequence.append(id)
        sequence.append(dict_seq[id]["nt_sequence"])
        sequence.append(dict_seq[id]["prot_sequence"])
        sequence.append(dict_seq[id]["chromosome"])
        sequence.append(dict_seq[id]["start_pos"])
        sequence.append(dict_seq[id]["end_pos"])
        sequence.append(dict_seq[id]["length"])
        sequence_list.append(sequence)
    return sequence_list



def parse_annotation(genome_dir):
    # retourne une liste des attributs à INSERT dans la table SQL Annotation pour un génome
    # [id_sequence, gene, gene_biotype, transcript_biotype, gene_symbol, description, validator_comment]

    # CREATE TABLE annotation(id_sequence : VARCHAR(32) PRIMARY KEY NOT NULL, 
    #                         gene : VARCHAR(32), 
    #                         gene_biotype : VARCHAR(128), 
    #                         transcript_biotype : VARCHAR(128), 
    #                         gene_symbol : VARCHAR(8), 
    #                         description : VARCHAR(128), 
    #                         validator_comment : VARCHAR(256), 
    #                         CONSTRAINT FKannot_id_sequence FOREIGN KEY (id_sequence) REFERENCES sequence(id_sequence))
    directory = "/".join(genome_dir.split("/")[0:-1])
    genome = genome_dir.split("/")[-1]

    annotation_list = list()

    with open(directory + genome + "_cds.fa") as f:
             cds_file = f.readlines()

    for line in cds_file:
        if ">" in line:
            # On divise la ligne d'info '>' en liste pour obtenir les différentes catégories
            info = line.strip().split(" ")
            # Problème avec .split(" "), les différentes catégories sont séparées par des " "
            # Il y a aussi des " " entre les différents mot dans la catégorie "description"
            # donc .split(" ") donne :
            # [..., 'description:Probable', 'transport', 'ATP-binding', 'protein', 'msbA']
            # alors qu'on voudrait :
            # [..., 'description:Probable transport ATP-binding protein msbA']
            for i, item in enumerate(info):
                if "description:" in item:
                    # En énumérant la liste, quand on arrive à l'élement qui contient "description:"
                    # On grèffe tous les éléments suivants de la liste à la suite avec .join()
                    info[i] = " ".join(info[i:])
                    # Puis on enleve la partie de la liste contenant les éléments qu'on a déjà récupéré
                    info = info[:i+1]

            # Extraire les élements d'annotations pour les ajouter au dictionnaire
            id_sequence = info[0].split(">")[1]
            
            gene = info[3].split(":")[1]
            gene_biotype = info[4].split(":")[1]
            transcript_biotype = info[5].split(":")[1]

            # "gene_symbol" n'est pas forcement présent
            # donc on considère les différents cas possibles
            if "gene_symbol" in info[6]:
                gene_symbol = info[6].split(":")[1]
                description = info[7].split(":")[1]

            elif "description" in info[6]:
                gene_symbol = ""
                description = info[6].split(":")[1]
            
            annotation_list.append([id_sequence, gene, gene_biotype, transcript_biotype, gene_symbol, description, ""])

    return annotation_list

