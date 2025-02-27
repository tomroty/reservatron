# Use Case : Système de Réservation "Réservatron"

## Acteurs

* **Utilisateur** : Personne qui crée un compte, prend des rendez-vous et gère ses informations.
* **Système** : Interface web et backend qui gèrent les interactions et les données.

## Cas d'utilisation principaux

### 1. Création de compte utilisateur

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur n'a pas de compte existant.
* **Déroulement** :

  1. L'utilisateur accède à la page d'inscription (`register.php`).
  2. Il complète le formulaire avec ses informations (nom, prénom, date de naissance, adresse, téléphone, email, mot de passe).
  3. Le système vérifie l'unicité de l'email et la validité des données.
  4. Un email de vérification est envoyé avec un token unique.
  5. L'utilisateur confirme son compte en cliquant sur le lien de vérification.
* **Postconditions** : L'utilisateur possède un compte actif et peut se connecter.

### 2. Authentification de l'utilisateur

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur possède un compte.
* **Déroulement** :

  1. L'utilisateur accède à la page de connexion (`login.php`).
  2. Il saisit son email et son mot de passe.
  3. Le système vérifie les informations d'authentification.
  4. Si valides, une session est créée pour l'utilisateur.
* **Postconditions** : L'utilisateur est connecté et peut accéder aux fonctionnalités réservées.

### 3. Gestion du profil utilisateur

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur est connecté.
* **Déroulement** :

  1. L'utilisateur accède à son profil (`profile.php`).
  2. Il peut visualiser ses informations personnelles.
  3. Il peut modifier ses informations via editProfile.php.
  4. Le système vérifie et enregistre les modifications après confirmation du mot de passe actuel.
* **Postconditions** : Les informations du profil sont mises à jour.

### 4. Consultation des créneaux disponibles

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur est connecté.
* **Déroulement** :

  1. L'utilisateur accède à la page de réservation (`booking.php`).
  2. Le système affiche un calendrier avec les créneaux des 7 prochains jours.
  3. Les créneaux déjà réservés sont visuellement distingués et désactivés.
* **Postconditions** : L'utilisateur visualise les disponibilités pour prendre rendez-vous.

### 5. Prise de rendez-vous

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur est connecté.
* **Déroulement** :

  1. L'utilisateur sélectionne un créneau disponible dans le calendrier.
  2. Il confirme sa réservation.
  3. Le système enregistre le rendez-vous et actualise les disponibilités.
* **Postconditions** : Le rendez-vous est créé et associé à l'utilisateur.

### 6. Gestion des rendez-vous

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur est connecté et a des rendez-vous.
* **Déroulement** :

  1. L'utilisateur accède à la page de gestion des rendez-vous (`appointments.php`).
  2. Il visualise la liste de ses rendez-vous.
  3. Il peut annuler un rendez-vous via cancelAppointment.php.
* **Postconditions** : Le rendez-vous est supprimé et le créneau est libéré.

### 7. Contact avec l'administration

* **Acteur principal** : Utilisateur
* **Préconditions** : Aucune (accessible même sans connexion).
* **Déroulement** :

  1. L'utilisateur accède au formulaire de contact (`contact.php`).
  2. Il remplit les champs nom, email, sujet et message.
  3. Le système enregistre le message et confirme sa réception.
* **Postconditions** : Le message est stocké dans la base de données.

### 8. Suppression de compte

* **Acteur principal** : Utilisateur
* **Préconditions** : L'utilisateur est connecté.
* **Déroulement** :

  1. L'utilisateur accède à son profil.
  2. Il sélectionne l'option "Supprimer mon compte".
  3. Le système supprime toutes les données associées à l'utilisateur.
  4. La session est détruite.
* **Postconditions** : Le compte utilisateur et ses rendez-vous sont supprimés de la base de données.

## Points techniques à noter

* Le système utilise des jetons CSRF pour protéger les formulaires
* Les mots de passe sont hachés avec `password_hash()`
* Les requêtes SQL utilisent des requêtes préparées via PDO pour éviter les injections
* Les créneaux de rendez-vous sont proposés de 8h à 18h sur les 14 prochains jours