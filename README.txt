Hugo CARBIENER

Taches : 

1   prise de connaissance du cahier des charges	                                        OBLIGATOIRE		 
2	initialisation du projet Symfony	                                                OBLIGATOIRE		 
3	gestion du code source avec Git	                                                    RECOMMANDÉ	 	 
4	ajout au modèle des données des entités liées Propriétaire et Couette-et-café	    OBLIGATOIRE		 
5	ajout d'une association entre Couette et café et Propriétaire	                    OBLIGATOIRE		 
6	ajout de l'entités Région	                                                        OBLIGATOIRE	 
7	ajout d'une association entre Régions et Couette et cafés	                        OBLIGATOIRE		 
8	ajout de données de tests chargeables avec les fixtures	                            OBLIGATOIRE	
9	création du "front-office" de consultation des Annonces par région	                OBLIGATOIRE
10  ajout des menus de navigation dans l'application	                                OBLIGATOIRE
11  ajout de CRUDs en "backoffice"	 	 
12 	ajout des Utilisateurs au modèle de données	                                        FORTEMENT RECOMMANDÉ	
13 	ajout de l'authentification	                                                        FORTEMENT RECOMMANDÉ	
14  ajout de la gestion de la mise en ligne d'images pour des photos dans les annonces	RECOMMANDÉ
15  ajout de mise en forme avec Bootstrap (ou un autre framework CSS)	                FORTEMENT RECOMMANDÉ
16  utilisation des messages flash pour les CRUDs
17  ajout d'une gestion de marque-pages/panier dans le front-office	                    FORTEMENT RECOMMANDÉ
18  particularisation de l'affichage des pages selon le profil d'utilisateur	        RECOMMANDÉ
19  protection de l'accès aux routes interdites selon le profil	                        FORTEMENT RECOMMANDÉ

Authentification:

Le site dispose d'une système d'enregistrement qui crée des Utilisateurs avec les droits USER.
Toutefois, deux Utilisateurs ont été implémentés :
- admin:
    id: admin@localhost
    password: password
    role: ADMIN 
- user:
    id: user@localhost
    password: password
    role: USER

    