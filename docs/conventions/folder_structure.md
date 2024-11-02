# Struttura delle cartelle che compongono il codice

## Struttura progetto ##
```
/root
│
├── /public             # Cartella pubblica accessibile via web
│   ├── /css           # File CSS
│   ├── /js            # File JavaScript
│   ├── /html           # File JavaScript
│   ├── /images        # Immagini
│   ├── index.php      # Pagina principale
│
├── /src               # Codice sorgente
│   ├── /config        # File di configurazione (database, ecc.)
│   ├── /models        # Modelli PHP (interazione con il database)
│   ├── /controllers   # Controllori PHP (logica di business)
│   └── /views         # File di vista (HTML/PHP)
│
├── /docs              # vedere indice documentazione per maggiori informazioni
│   ├── /assets        
│   ├── /conventions   
│   ├── /database      
│   ├── /SEO           
│   └── /WebSite       
|
└── README.md          # Documentazione del progetto
```