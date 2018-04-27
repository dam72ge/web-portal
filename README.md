# web-portal
A complete italian web portal: Promogenova, which was active from 2009 to 2017.

[ENGLISH]


INTRODUCTION
Promogenova was a web portal in Italian language, active from 2009 to 2017. Created in 2009 by scratch, with pure code (HTML / CSS and PHP / MySql, without frameworks), it underwent a major revision in 2013 with the transition to html5 and a responsive layout. The present version, slightly updated to php7, basically proposes the last one. For obvious reasons, the data recorded in the database have been reduced to a minimum, that is only old customers who have ceased their activities have been kept.

LICENSE
The commercial use of the "Promogenova" project, with or without any improvements, is allowed by the license and the creator without any other request except than a kind communication and a public recognition of my work.

STRUCTURE OF THE WEB PORTAL
For brevity and practicality, let's say that the folder config is the heart of the portal, because in it are contained the structural components (head, footer etc.), the codes and classes with which every single page is related to the MySql database. In addition to this, you can directly access the administration of the portal through a password.
The access code and the database password are contained in the mydb.php file.
Since every page and every folder of the portal is aimed at indexing on search engines, the general organization and the structure of the portal are therefore dynamically modeled on five main levels interconnected to each other, to facilitate the visitor's reach and navigation, in particular, obviously towards the customer pages:
- search by commercial categories;
- research on the territory (Genoa, regions, provinces, etc.);
- activities and customer pages;
- events;
- associative networks.
Each page and each folder are interconnected by a dense network of links and internal references, aimed at conveying especially the pages and articles of customer activities.
Therefore, in the mapping, the activities and the pages of the customers have a prominent role.
The mapping files are present in the sitemap folder and are nothing more than calls from the database converted to xml. Similarly, the data were processed to make available an RSS service that allows visitors to be updated on a daily basis.

STRUCTURE OF THE PAGE
All pages are built according to the same scheme:
1) database call and inclusion of classes;
2) preparation of data, which are then organized into arrays and prepared for both indexing (keywords) and visualization;
3) inclusion of the html part (head and header, containing the main navigation menu, fixed on all pages);
4) visualization of the data in the body;
5) inclusion of the footer that closes the page and the calls to the database.

HOW CUSTOMER SPACES AND THEIR ADMIN PANELS WORK
The spaces managed directly by the costumers (the so-called "vetrine web") are configured as small standardized sites within the portal. The access to the administration panel (the admin-client folder) is done with a personalized password and automatically opens a PHP session in which all the data relating to the customer are recorded. In the admin, the client has at his disposal the deadlines and data concerning his contract, information on privacy, etc .; but above all it can directly manage, through intuitive forms summarized by practical suggestions, the sections, the texts and the images that make up its web window:
- logo;
- who we are (description of the activity);
- contacts and links (sites, email, telephone, etc.);
- timetables;
- photogallery;
- articles (products, services, etc.);
- events (if enabled);
- video;
- fast search tag.
The name of the folder, the password and the address (with the automatic display of the relevant map on the showcase) remain in the exclusive scope of the portal administrator.
Every modification, deletion or insertion of data have immediate effect.
From a purely technical point of view, all "vetrine web" are identical folders for structure and content, which differ only by the name of the folder (the name of the client activity), logos and image galleries. Within each window are therefore present the same php files; each of these files invokes the corresponding in the models folder (modelli) in which from the name of the folder, passing to the php class, all the data concerning the customer are obtained.

AN ALWAYS UPDATED PORTAL. PARTICULARITY OF THE HOMEPAGE AND DIRECTORIES, ESSENTIALITY OF SOCIAL MEDIA
To avoid the risk of appearing as empty pages, mere "skeletons" without information, each page, starting from the Home, in addition to the usual internal links and what is published by customers, tends to give information about events, images, videos and everything that happens in the territory or is related to commercial categories. All of this required, of course, an extra effort on the part of those administering the portal: that is, producing and publishing material that was relevant and up-to-date, especially where customer publications were insufficient or outdated.
Therefore, the communication on social media had the task not only to increase the visibility of customers (through first of all their articles), but to keep the attention on the portal as an amplifier of what was happening on the territory, stimulator of interconnections and creator , in turn, networks aimed at strengthening the idea, in citizens, of the convenience and usefulness of living their territory.


PASSWORDS

Portal administration panel:
Url: 		[root] / config
Password: 	admin

Customer administration panel, for example La bottega delle fate:
Url:		[root] /login-clienti.php
User:		bottegafate2
Password:	bottegafate2




* * *


[ITALIAN]


INTRODUZIONE
Promogenova è stato un portale web in lingua italiana attivo dal 2009 al 2017. Creato nel 2009 da zero, con codice puro (HTML/CSS e PHP/MySql, senza frameworks), ha subito una forte revisione nel 2013 con il passaggio a html5 e a un layout responsive. La presente versione, lievemente aggiornata a php7, ripropone dunque sostanzialmente l’ultima. Per ovvie ragioni, i dati registrati nel database sono stati ridotti al minimo, mantenendo cioè solo quelli relativi a vecchi clienti che hanno cessato le rispettive attività.

LICENZA DI UTILIZZO
L’utilizzo o il riutilizzo commerciale del progetto “Promogenova”, con o senza migliorie, è ammesso dalla licenza e dal sottoscritto senza altre richieste che una cortese comunicazione e un pubblico riconoscimento del mio lavoro.

STRUTTURA DEL PORTALE
Per brevità e praticità, si può dire che la cartella config è il cuore pulsante del portale, poiché in essa sono contenuti le componenti strutturali (head, footer ecc),  i codici e le classi con cui ogni singola pagina si relaziona al database mysql. Oltre a ciò, da config si accede direttamente all’amministrazione dello stesso portale via password.
Il codice di chiamata e la password del database sono contenuti nel file mydb.php.
Essendo ogni pagina e ogni cartella del portale finalizzate all’indicizzazione sui motori di ricerca, l’organizzazione generale e la struttura stessa del portale sono quindi modellate dinamicamente su cinque principali livelli interconnessi tra loro, per agevolare il raggiungimento del visitatore e la sua navigazione, in particolare ovviamente verso le pagine dei clienti:
- ricerca per categorie commerciali;
- ricerca sul territorio (Genova, regioni, province ecc.);
- attività e pagine dei clienti;
- eventi;
- reti associative.
Ogni pagina e ogni cartella sono interconnesse da una fitta rete di link e rimandi interni, volti a veicolare soprattutto il raggiungimento delle pagine e degli articoli delle attività clienti. 
In sede di mappizzazione, le attività e le pagine dei clienti hanno perciò un ruolo preminente. 
I file di mappizzazione sono presenti nella cartella  sitemap e non sono altro che chiamate dal databese convertite in xml. Analogamente, i dati sono stati trattati per rendere disponibile un servizio RSS che consente l’aggiornamento quotidiano dei visitatori.

STRUTTURA DELLA PAGINA
Tutte le pagine sono costruite secondo il medesimo schema:
1) chiamata del database e inclusione delle classi;
2) preparazione dei dati, che vengono dunque organizzati in array e predisposti sia per l’indicizzazione (keywords), sia per la visualizzazione;
3) inclusione della parte html (head e header, contenente il menù principale di navigazione, fisso su tutte le pagine);
4) visualizzazione dei dati nel body;
5) inclusione del footer che chiude la pagina e le chiamate al database.

FUNZIONAMENTO DI VETRINE E ADMIN DEI CLIENTI
Gli spazi gestiti direttamente dal cliente (le cosiddette vetrine web) si configurano come piccoli siti standardizzati all’interno del portale. L’accesso al pannello di amministrazione (cartella admin-clienti ) avviene con password personalizzata e apre automaticamente una sessione PHP in cui vengono registrati tutti i dati relativi al cliente. Nell’admin, il cliente ha a disposizione le scadenze e i dati che riguardano il suo contratto, informazioni sulla privacy ecc.; ma soprattutto può gestire direttamente, tramite form intuitivi compendiati da suggerimenti pratici, le sezioni, i testi e le immagini di cui si compone la sua vetrina web:  
- logo;
- chi siamo (descrizione dell’attività);
- contatti e link (siti, email, telefono ecc.);
- orari;
- fotogallery;
- articoli (prodotti, servizi, ecc.);
- eventi (se abilitato);
- video;
- tag di ricerca veloce.
Il nome della cartella, la password e l’indirizzo (con la visualizzazione automatica della relativa mappa sulla vetrina) restano pertinenza esclusiva dell’amministratore del portale.
Ogni modifica, cancellazione o inserimento di dati hanno effetto immediato.
Da un punto di vista squisitamente tecnico, tutte le vetrine web sono cartelle identiche per struttura e contenuto, le quali differiscono soltanto per nome della cartella (il nome dell’attività cliente), loghi e gallerie di immagini. All’interno di ogni vetrina sono dunque presenti gli stessi file php; ognuno di questi file richiama il corrispettivo nella cartella modelli in cui dal nome della cartella, passanto alla classe php, si ricavano tutti i dati inerenti al cliente. 

UN PORTALE SEMPRE AGGIORNATO. PARTICOLARITA’ DELLA HOMEPAGE E DELLE DIRECTORY, ESSENZIALITA’ DEI SOCIAL MEDIA
Per ovviare al rischio di apparire come pagine nude, meri “scheletri” privi di informazioni, ogni pagina, a cominciare dalla Home, oltre ai consueti link interni e ciò che viene pubblicato dai clienti, tende a dare informazione di eventi, immagini, video e tutto ciò che avviene nel territorio o è relativo a categorie commerciali. Tutto ciò richiedeva, naturalmente, uno sforzo supplementare da parte di chi amministrava il portale: cioè produrre e pubblicare materiale che fosse attinente e aggiornato, specialmente laddove le pubblicazioni dei clienti erano insufficienti o datate. 
Pertanto, la comunicazione sui social media aveva come compito non solo quello di aumentare la visibilità dei clienti (tramite anzitutto i loro articoli), ma di tenere viva l’attenzione sul portale come amplificatore di ciò che avveniva sul territorio, stimolatore di interconnessioni e creatore, a sua volta, di reti mirati a rafforzare l’idea, nei cittadini, della convenienza e dell’utilità di vivere il proprio territorio. 


PASSWORD

Pannello di amministrazione del portale:
Url:		[root]/config
Password:	admin

Pannello di amministrazione del cliente, per esempio La bottega delle fate:
Url:		[root]/login-clienti.php
Utente:		bottegafate2
Password:	bottegafate2


