import os

# --- CONFIGURAZIONE ---

# Cartella radice del progetto ('.' indica la cartella corrente)
ROOT_DIR = '.' 

# Nome del file di output
OUTPUT_FILE = 'codice_completo_progetto.txt'

# Estensioni dei file da includere (aggiungi o rimuovi quelle che ti servono)
ALLOWED_EXTENSIONS = {
    '.py',   # Python
    '.java', # Java
    '.js',   # JavaScript
    '.ts',   # TypeScript
    '.cpp',  # C++
    '.h',    # C++ Header
    '.cs',   # C#
    '.php',  # PHP
    '.html', # HTML
    '.css'   # CSS
}

# Cartelle da IGNORARE (per evitare di copiare librerie, git, file compilati, etc.)
EXCLUDED_DIRS = {
    '.git', 
    '__pycache__', 
    'node_modules', 
    'venv', 
    'env', 
    '.idea', 
    '.vscode', 
    'bin', 
    'obj',
    'build',
    'dist'
}

def is_text_file(filename):
    """Controlla se il file ha un'estensione valida."""
    return any(filename.endswith(ext) for ext in ALLOWED_EXTENSIONS)

def generate_project_text_file():
    try:
        with open(OUTPUT_FILE, 'w', encoding='utf-8') as outfile:
            outfile.write(f"=== CONTENUTO DEL PROGETTO: {os.path.abspath(ROOT_DIR)} ===\n\n")
            
            # Attraversa le directory
            for root, dirs, files in os.walk(ROOT_DIR):
                # Rimuove le directory escluse dalla ricerca (modifica la lista dirs in-place)
                dirs[:] = [d for d in dirs if d not in EXCLUDED_DIRS]
                
                for file in files:
                    if is_text_file(file):
                        # Evita di includere lo script stesso o il file di output
                        if file == OUTPUT_FILE or file == os.path.basename(__file__):
                            continue

                        file_path = os.path.join(root, file)
                        
                        try:
                            with open(file_path, 'r', encoding='utf-8') as infile:
                                content = infile.read()
                                
                                # Scrittura intestazione file
                                separator = "=" * 80
                                outfile.write(f"\n{separator}\n")
                                outfile.write(f"FILE: {file_path}\n")
                                outfile.write(f"{separator}\n\n")
                                
                                # Scrittura contenuto
                                outfile.write(content)
                                outfile.write("\n")
                                
                                print(f"Aggiunto: {file_path}")
                                
                        except Exception as e:
                            print(f"ERRORE nella lettura di {file_path}: {e}")
                            outfile.write(f"\n[ERRORE DI LETTURA DEL FILE: {e}]\n")

        print(f"\n--- COMPLETATO ---")
        print(f"Tutto il codice è stato salvato in: {OUTPUT_FILE}")

    except Exception as e:
        print(f"Errore critico: {e}")

if __name__ == "__main__":
    generate_project_text_file()