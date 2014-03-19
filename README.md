ecoute-prolongee-v2
===================

Écoute Prolongée - V2 - from scratch

### Todo

* [x] Ajouter le player mp3
* [x] Build les shortcodes/metabox/post type pour le player mp3 **No need**
* [ ] Ajouter la partie responsive/mobile prout
* [ ] Refaire un check complet des fichiers
* [ ] Minify les .js (c'est quand même cool)
* [ ] Vérif complète de la css
* [ ] Minify de la css
* [ ] Mise en ligne ?
* [x] Ajouter le slider > Plugin Meta Slider (badass, léger, parfait)
* [x] Ajouter les custom post type et post meta du slider > **No need**
* [x] Construire la partie ajax du site
* [x] Ajouter des options au thème (couleurs, position du player, etc ...)
* [x] Changer l'accès du readme.txt sur la version en prod dans .htaccess (osef en fait pour le moment)
* [x] Supprimer les tags dans style.css
* [x] Ajouter un meilleur copyright dans les fichiers du thème > **No need**
* [x] Empêcher d'accéder à certains fichiers avec un `die`
* [x] Construire la page 'single podcast' pour afficher les podcasts

### Issues 

**Slider :**

Problème avec le plugin du slider actuel. Si on est sur une autre page que la home et qu'on revient sur la home, parfois, le slider ne se charge pas.

### À propos du player mp3

Pour le fonctionnement du player. Il faudrait faire en sorte qu'il joue n'importe quel morceau qui est présent sur le site. Que l'on mette un embed Soundcloud ou un embed Grooveshark.

Il faudrait dans l'idéal qu'il fonctionne avec **Grooveshark**, **Soundcloud** et peut-être **Spotify** si possible avec l'api.

Quand on clique sur le menu "Playlist" sur le site, les playlists s'affichent. Si on hover une playlist, il y a un petit bouton "play". Lorsque le player est activé, ce bouton play devra lire la musique dans le player. Si on désactive le player, ce bouton play renverra sur la musique sur Soundcloud ou autre.

En gros il faudrait que le player ait toutes les fonctionnalités présentes actuellement sur le site (ÉcouteProlongée)[http://www.ecoute-prolongee.com].