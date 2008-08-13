<?php
/***************************************************************************
 *                           lang_main.php (English)
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_main.php,v 2.00 2008/03/07 13:46:51 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/
global $phprlang;

// � = �   � = � 

// logging language file
require_once('lang_log.php');

// page specific language file
require_once('lang_pages.php');

// world of warcraft language file
require_once('lang_wow.php');

// data output headers (Reports.php)
$phprlang['add_team']='Cochez pour ajouter à l\'équipe';
$phprlang['add_team_dropdown_text']='Sèlectionnez une équipe pour y ajouter des membres';
$phprlang['team_global']='Sélection des groupes disponibles pour tous les Raids';
$phprlang['sort_desc']='Click here to sort (in descending order) by ';
$phprlang['sort_asc']='Click here to sort (in ascending order) by '; 
$phprlang['male'] = 'Male';
$phprlang['female'] = 'Femelle';
$phprlang['class'] = 'Classe';
$phprlang['date'] = 'Date';
$phprlang['description'] = 'Description';
$phprlang['email'] = 'E-mail';
$phprlang['guild'] = 'Guilde';
$phprlang['guild_name'] = 'Nom de la Guilde';
$phprlang['guild_master'] = 'Maitre de Guilde';
$phprlang['guild_tag'] = 'Tag Guilde';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Groupage';
$phprlang['level'] = 'Niveau';
$phprlang['location'] = 'Donjon';
$phprlang['max_lvl'] = 'Niv Max';
$phprlang['max_raiders'] = 'Limite de joueurs';
$phprlang['locked_header'] = 'Locked?';
$phprlang['message'] = 'Message';
$phprlang['min_lvl'] = 'Niv Min';
$phprlang['name'] = 'Nom';
$phprlang['officer'] = 'Créateur';
$phprlang['no_data'] = 'Vide';
$phprlang['posted_by'] = 'Posté par';
$phprlang['race'] = 'Race';
$phprlang['start_time'] = 'Heure de Début';
$phprlang['team_name'] = 'Nom de l\'équipe';
$phprlang['time'] = 'Heure';
$phprlang['title'] = 'Titre';
$phprlang['totals'] = 'Total';
$phprlang['username'] = 'Nom du Joueur';
$phprlang['records'] = 'Enregistrement(s)';
$phprlang['to'] = 'to';
$phprlang['of'] = 'of';
$phprlang['total'] = 'total';
$phprlang['section'] = 'Section';
$phprlang['prev'] = 'Préc';
$phprlang['next'] = 'Suiv';
$phprlang['earned'] = 'Gagné';
$phprlang['spent'] = 'Passé';
$phprlang['adjustment'] = 'Ajustement';
$phprlang['dkp'] = 'DKP';

// roles
$phprlang['role'] = 'Role';
$phprlang['role_none'] = '-';
$phprlang['role_tank'] = 'Tank';
$phprlang['role_heal'] = 'Healer';
$phprlang['role_melee'] = 'CAC';
$phprlang['role_ranged'] = 'Distance';
$phprlang['role_tankmelee'] = 'Tank ou CAC';

$phprlang['role_tanks'] = 'Tanks';
$phprlang['role_heals'] = 'Healers';
$phprlang['role_melees'] = 'CACs';
$phprlang['role_ranges'] = 'Distances';
$phprlang['role_tankmelees'] = 'Tanks/CACs';

$phprlang['max_tanks'] = 'Max Tanks';
$phprlang['max_heals'] = 'Max Healers';
$phprlang['max_melees'] = 'Max CACs';
$phprlang['max_ranged'] = 'Max Distances';
$phprlang['max_tkmels'] = 'Max Tank/CACs';

// errors
$phprlang['connect_socked_error'] = 'Erreur de connection au socket, erreur : %s';
$phprlang['invalid_group_title'] = 'Le groupe existe déja';
$phprlang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$phprlang['invalid_option_title'] = 'Entrée invalide pour cette page';
$phprlang['invalid_option_msg'] = 'Vous avez essayé d\'entrer dans cette page avec une entrée invalide.';
$phprlang['no_user_msg'] = 'Cet utilisateur n\'existe pas ou a été éffacé.';
$phprlang['no_user_title'] = 'Utilisateur non existant';
$phprlang['print_error_critical'] = 'erreur critique!';
$phprlang['print_error_details'] = 'Détails';
$phprlang['print_error_minor'] = 'erreur mineure!';
$phprlang['print_error_msg_begin'] = 'Sorry, phpRaid has encountered ';
$phprlang['print_error_msg_end'] = 'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!';
$phprlang['print_error_page'] = 'Page';
$phprlang['print_error_query'] = 'Requète';
$phprlang['print_error_title'] = 'Uh oh! You hit a boo boo';
$phprlang['socket_functions_disabled'] = 'Update checked failed to connect to server.';

// forms
$phprlang['asc'] = 'ascendant';
$phprlang['auth_phpbb_no_groups'] = 'Auncun groupe disponible';
$phprlang['desc'] = 'descendant';
$phprlang['form_error'] = 'Error with your form submission';
$phprlang['form_select'] = 'S�lectionnez';
$phprlang['no'] = 'Non';
$phprlang['none'] = 'Aucun';
$phprlang['permissions_form_description'] = 'Vous devez ajouter une description';
$phprlang['permissions_form_name'] = 'Vous devez renseigner un nom';
$phprlang['profile_error_arcane'] = 'Arcanes doit etre un nombre';
$phprlang['profile_error_class'] = 'Vous devez sèlectionner une classe';
$phprlang['profile_error_dupe'] = 'Un personnage porte déja ce nom';
$phprlang['profile_error_fire'] = 'Feu doit etre un nombre';
$phprlang['profile_error_frost'] = 'Givre doit etre un nombre';
$phprlang['profile_error_guild'] = 'Vous devez sèlectionner une guilde';
$phprlang['profile_error_level'] = 'Le niveau doit etre un nombre entre 1 et 70';
$phprlang['profile_error_name'] = 'Vous devez renseigner un nom';
$phprlang['profile_error_nature'] = 'Nature doit etre un nombre';
$phprlang['profile_error_race'] = 'Vous devez sèlectionner une race';
$phprlang['profile_error_role'] = 'Vous devez renseigner un role';
$phprlang['profile_error_shadow'] = 'Ombre doit etre un nombre';
$phprlang['raid_error_date'] = 'Vous devez entrer une date au format valide';
$phprlang['raid_error_description'] = 'La description doit etre écrite';
$phprlang['raid_error_limits'] = 'Toutes les limites de raid doivent etre numèriques';
$phprlang['raid_error_location'] = 'Ajouter un lieu de raid';
$phprlang['view_error_signed_up'] = 'Vous etes dèja inscrit avec ce personnage';
$phprlang['view_error_role_undef'] = 'Make sure that the Character in <a href="profile.php?mode=view">Profile</a> has a defined Role.';
$phprlang['yes'] = 'Oui';

// Buttons
$phprlang['submit'] = 'Valider';
$phprlang['reset'] = 'Réinitialiser';
$phprlang['confirm'] = 'Confirmer';
$phprlang['update'] = 'Modifier';
$phprlang['confirm_deletion'] = 'Confirmer Suppression';
$phprlang['filter'] = 'Filtrer';
$phprlang['addchar'] = 'Ajouter un Personnage';
$phprlang['updatechar'] = 'Modifier un Personnage';
$phprlang['login'] = 'S\'identifier';
$phprlang['logout'] = 'Déconnexion';
$phprlang['signup'] = 'S\'inscrire';


// generic information
$phprlang['delete_msg'] = 'NOTICE: La suppression est IRREVERSIBLE. <br>Cliquez sur le bouton pour confirmer.';
$phprlang['disable_header'] = 'Site en maintenance, contactez l\'administrateur si besoin.';
$phprlang['disable_message'] = 'phpRaid est actuellement en maintenance. Réessayez plus tard.';
$phprlang['login_title'] = 'Erreur d\'identification';
$phprlang['login_msg'] = 'Mauvais mot de passe ou mauvais Identifiant. Veuillez réessayer.';
$phprlang['userclass_msg'] = 'Your e107 user is not authorized to use phpRaid, please contact the system administrator.';
$phprlang['priv_title'] = 'Privilèges insuffisants';
$phprlang['priv_msg'] = 'Vosu n\'avez pas les privilèges pour accèder a cette page. Contactez l\'administrateur si vous pensez que c une erreur';
$phprlang['remember'] = 'Garder mon identifiant en mémoire';
$phprlang['welcome'] = 'Bienvenue ';

// Days of the Week
$phprlang['sunday'] = 'Dimanche';
$phprlang['monday'] = 'Lundi';
$phprlang['tuesday'] = 'Mardi';
$phprlang['wednesday'] = 'Mercredi';
$phprlang['thursday'] = 'Jeudi';
$phprlang['friday'] = 'Vendredi';
$phprlang['saturday'] = 'Samedi';
$phprlang['2ltrsunday'] = 'Dim';
$phprlang['2ltrmonday'] = 'Lun';
$phprlang['2ltrtuesday'] = 'Mar';
$phprlang['2ltrwednesday'] = 'Mer';
$phprlang['2ltrthursday'] = 'Jeu';
$phprlang['2ltrfriday'] = 'Ven';
$phprlang['2ltrsaturday'] = 'Sam';
							
// links
$phprlang['announcements_link'] = '&raquo; Messages D\'Accueil';
$phprlang['configuration_link'] = '&raquo; Configuration';
$phprlang['guilds_link'] = '&raquo; Guildes';
$phprlang['home_link'] = '&raquo; Page D\'Accueil';
$phprlang['calendar_link'] = '&raquo; Calendrier Graphique';
$phprlang['locations_link'] = '&raquo; Lieux De Raid';
$phprlang['logs_link'] = '&raquo; Journaux';
$phprlang['permissions_link'] = '&raquo; Droits';
$phprlang['profile_link'] = '&raquo; Mes Persos';
$phprlang['raids_link'] = '&raquo; Raids';
$phprlang['register_link'] = '&raquo; Enregistrement';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Utilisateurs';
$phprlang['lua_output_link'] = '&raquo; Lua output raids';
$phprlang['index_link'] = '&raquo; Forum AC';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = 'Cliquer ici pour trier par ';

// tooltips
$phprlang['add'] = 'Ajouter';
$phprlang['announcements'] = 'Messages D\'accueil';
$phprlang['arcane'] = 'Arcanes';
$phprlang['calendar'] = 'Calendrier';
$phprlang['cancel'] = 'Annuler inscription';
$phprlang['cancel_msg'] = 'Vouz avez annulé votre inscription pour ce raid';
$phprlang['comments'] = 'Commentaires';
$phprlang['configuration'] = 'Configuration';
$phprlang['delete'] = 'Supprimer';
$phprlang['description'] = 'Description';
$phprlang['druid_icon'] = 'Cliquez pour voir les Druides';
$phprlang['edit'] = 'Editer';
$phprlang['edit_comment'] = 'Editer Commentaire';
$phprlang['fire'] = 'Feu';
$phprlang['frost'] = 'Givre';
$phprlang['frozen_msg'] = 'Les inscriptions pour ce raid sont fermées.';
$phprlang['group_name'] = 'Nom du groupe';
$phprlang['group_description'] = 'Description du Groupe';
$phprlang['guilds'] = 'Guildes';
$phprlang['has_permission'] = 'Has Permission';
$phprlang['hunter_icon'] = 'Cliquez pour voir les Chasseurs';
$phprlang['in_queue'] = 'Placer le personnage en file d\'attente';
$phprlang['last_login_date'] = 'Dernière connexion';
$phprlang['last_login_time'] = 'Heure de la dernière connexion';
$phprlang['locations'] = 'Lieux';
$phprlang['logs'] = 'Journaux';
$phprlang['lua'] = 'LUA and macro output';
$phprlang['mage_icon'] = 'Cliquez pour voir les Mages';
$phprlang['mark'] = 'Marquer en ancien raid';
$phprlang['nature'] = 'Nature';
$phprlang['new'] = 'Marquer en nouveau raid';
$phprlang['not_signed_up'] = 'Cliquez ici pour vous inscrire au Raid';
$phprlang['out_queue'] = 'Placer le joueur dans le raid';
$phprlang['paladin_icon'] = 'Cliquez pour voir les Paladins';
$phprlang['permissions'] = 'Droits';
$phprlang['priest_icon'] = 'Cliquez pour voir les prètres';
$phprlang['priv'] = 'Privilèges';
$phprlang['profile'] = 'Personnages';
$phprlang['raids'] = 'Raids';
$phprlang['remove_group'] = 'Remove group from set';
$phprlang['remove_user'] = 'Remove user from set';
$phprlang['rogue_icon'] = 'Cliquez pour voir les Voleurs';
$phprlang['shadow'] = 'Ombre';
$phprlang['shaman_icon'] = 'Cliquez pour voir les Chamans';
$phprlang['signed_up'] = 'You are signed up for this raid';
$phprlang['signup_add'] = 'Add user to signups';
$phprlang['signup_delete'] = 'Supprimer le joueur du raid (permanant)';
$phprlang['users'] = 'Utilisateurs';
$phprlang['warlock_icon'] = 'Cliquez pour voir les Démonistes';
$phprlang['warrior_icon'] = 'Cliquez pour voir les Guerriers';

?>