# Projet « Cyberfolio »

## Compte administrateur
- URL du *back-office* :
http://localhost:8000/login
- Identifiant :
`admin`
- Mot de passe :
`admin`

## État d'avancement
Back-office :
- [x] Gestion des utilisateurs.
- [x] Gestion des projets.

Front-office :
- [x] Affichage de la liste de tous les utilisateurs.
- [ ] Affichage de la liste de tous (en cours)
- [x] Affichage du profil d’un utilisateur avec ses projets et ses informations.
- [ ] Affichage Moderne via le composant AssetMapper. (feat à venir)
- [ ] Mise en place d’une recherche ou d’un tri sur les projets. (feat à venir)

Authentification & Autorisation :
- [x] Authentification via formulaire (login, logout).
- [x] Gestion des rôles (utilisateur et administrateur).

Gestion des assets :
- [x] Upload d’images pour les projets et les profils.
- [ ] Optimisation des assets pour le déploiement.


## Difficultés rencontrées et solutions

#### Difficultés :
Gestion des relations entre entités :
Les relations, comme les projets et leurs technologies, ont nécessité une gestion fine dans les formulaires et le back-end.

Problèmes de routage :
Des erreurs sur certaines routes, notamment pour les projets, ont nécessité des ajustements dans les contrôleurs et les templates.

#### Solutions :
Débogage avec les outils Symfony :
Utilisation des commandes debug:router et doctrine:schema:validate pour corriger les problèmes de configuration.

Refactorisation des routes :
Les préfixes de routes ont été simplifiés pour éviter les conflits et rendre les URLs plus intuitives.

## Bilan des acquis
- Maîtrise des relations entre entités dans Doctrine (OneToMany, ManyToMany, etc.).
- Gestion avancée des formulaires Symfony, notamment avec des champs complexes (upload d'images, sélection multiple).
- Mise en place d’un système d’authentification et d’autorisation avec gestion des rôles (ROLE_USER, ROLE_ADMIN).
- Création d'un back-office fonctionnel permettant de gérer des utilisateurs, des projets et des technologies.
- Développement d’un front-office interactif, affichant les projets et les profils de manière dynamique.

## Remarques complémentaires
Déploiement prévu : Des ajustements seront nécessaires pour le déploiement en production, notamment sur la configuration des assets et la base de données.

#### Améliorations à prévoir :
- Faire le CSS/JS du front-office pour un affichage plus moderne.
- Ajout d’un système de recherche pour les projets dans le front-office.
- Optimisation des performances pour les chargements de données volumineuses.

