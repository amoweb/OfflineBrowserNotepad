## OfflineBrowserNotepad

- HTML Wysiwyg (CKEditor 5)
- Save on server(php) or in local browser cache (window.localStorage)
- HTML export
- No security, very unsafe (HTML can contain scripts), do not use on public server (but this can be very practical on a private server)
- Vocal synthesis (fr, en)
- Records every version of the note

# Bloc note hors ligne pour navigateur
- HTML Wysiwyg (CKEditor 5)
- Peut sauvegarde en ligne (php) ou dans le cache du navigateur (window.localStorage)
- Export en HTML
- Aucune sécurité, dangereux (le HTML peut contenir du javascript), ne pas utiliser sur un serveur public (mais sur un serveur privé, c'est très pratique)
- Synthèse vocale (fr, en)
- Enregistrement de chaque version de chaque fichier

## Limitations
- Cannot delete a file
- No password
- No interface to select a note (do this with the link)

## Usage

https://server.fr/OfflineBrowserNotepad/#noteName (shot the HTML editor)

https://server.fr/OfflineBrowserNotepad/html/?id=noteName (show the note in HTML)

Buttons:

- Serv{ Put Get Prev Next } : Send or receive this note (noteName) on the server, see previous (next) backup of the note.
- Local{ Put Get } : Save or load this note (noteName) in browser cache
- Clr : clear all
- En : Read with english accent
- Fr : Lire en français

## Usage

- Probably buggy and useless for most people
- Store articles and read it later with you phone / ebook reader
- Notepad that works even when the phone if offline

