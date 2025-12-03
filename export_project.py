import os

# Configurazione: cartelle da ignorare (per non appesantire il file)
IGNORE_DIRS = {
    '.git', 'vendor', 'node_modules', 'storage', 'public', 
    '.idea', '.vscode', 'bootstrap', 'tests', 'lang'
}

# Estensioni file da includere (solo codice sorgente utile)
INCLUDE_EXTS = {
    '.php', '.js', '.vue', '.css', '.blade.php', '.json', '.env.example'
}

output_file = 'progetto_completo.txt'

def is_text_file(filepath):
    """Controlla se il file è leggibile come testo."""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            f.read(1024)
            return True
    except:
        return False

print("Inizio scansione progetto...")

with open(output_file, 'w', encoding='utf-8') as outfile:
    for root, dirs, files in os.walk('.'):
        # Rimuovi le cartelle ignorate dalla ricerca
        dirs[:] = [d for d in dirs if d not in IGNORE_DIRS]
        
        for file in files:
            # Controlla se l'estensione è tra quelle desiderate
            if any(file.endswith(ext) for ext in INCLUDE_EXTS):
                file_path = os.path.join(root, file)
                
                # Scrivi intestazione chiara per ogni file
                separator = "=" * 50
                outfile.write(f"\n\n{separator}\nFILE: {file_path}\n{separator}\n\n")
                
                try:
                    with open(file_path, 'r', encoding='utf-8', errors='replace') as infile:
                        outfile.write(infile.read())
                except Exception as e:
                    outfile.write(f"[ERRORE DI LETTURA: {e}]")

print(f"Fatto! È stato creato il file '{output_file}'. Caricalo nella chat.")