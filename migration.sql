-- noinspection SqlWithoutWhereForFile

set search_path = codewars;

delete from transaction where id > 0;
delete from studenttip where id > 0;
delete from tips where id > 0;
delete from studentExercise where id > 0;
delete from imageExamples where exercise_id > 0;
delete from exercise where id > 0;
delete from teacher where da != '';
delete from studentItem where id > 0;
delete from item where id > 0;
delete from token where user_id > 0;
delete from student where id > 0;
delete from notification where id > 0;
delete from "user" where id > 0;
delete from person where id > 0;

/*PERSON*/
alter sequence codewars.person_id_seq restart with 1;
insert into codewars.person(id, da, firstname, lastname, username, email) values (1, 'dadajuice', 'David', 'Tucker', 'Dadajuice', 'david.tucker2003@msn.com');
insert into codewars.person(id, da, firstname, lastname, username, email) values (116, '2029684', 'Marly', 'Cournoyer', 'Izuku Midoriya', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (117, '1448676', 'Ivan-Alberto', 'Diaz-Muy', 'MrMister', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (118, '6176471', 'Excellence', 'Ekanza Ezokola', 'ERROR 404', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (119, '2134218', 'Nicholas', 'Ferland', 'Ahza', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (120, '2136072', 'Alexandre', 'Gagné', 'AlexGagné', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (121, '2154718', 'Samuel', 'Gagné', 'LeoBobV2', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (122, '2183098', 'Philippe', 'Gagnon', 'Gagnon', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (123, '6176553', 'Diego', 'Hiebert', 'PlacidRaven', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (124, '1326333', 'Catherine', 'Lesieur', 'Koro Sensei', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (125, '2178274', 'Bradley', 'Loizeau', 'Bradley', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (126, '2146790', 'Xavier', 'Morin', 'CPT Major. Problems', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (127, '1929852', 'Audrey', 'Raymond', 'Unik', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (128, '1538902', 'Antoine', 'Rousseau', 'Rousseau', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (129, '2144667', 'Léo', 'Tessier', 'LeoBOB', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (130, '2167015', 'Ana Isabel', 'Torres Corredor', 'Isabel', null);
insert into codewars.person(id, da, firstname, lastname, username, email) values (131, 'josh', 'josh', 'josh', 'LEBEST', null);
alter sequence codewars.person_id_seq restart with 132;

/*USER*/
insert into codewars.user(id, da, password) values (1, 'dadajuice', '$2y$10$Nf3YH2vKsr1/joVZcdG1PO2IUvg8sNFncCbWERZxldVEn6c4RbXUa');
insert into codewars.user(id, da, password) values (116, '2029684', '$2y$10$seTJWVcxioxbaJdRIpMt3.h6GfaD6HPOz.fh/h1QhnPJRXUpz0NDG');
insert into codewars.user(id, da, password) values (117, '1448676', '$2y$10$0PKu.O1YXqV.TqtsC2Vr4OmMtxu.BnHx5fdT1hQczyIJE2zdzim0i');
insert into codewars.user(id, da, password) values (118, '6176471', '$2y$10$9LQCNplOLjUtZ69E98mFNuDHJqYKdK9V/WqFYS2Lr5glb9VGY0aDK');
insert into codewars.user(id, da, password) values (119, '2134218', '$2y$10$wzqEjo1NHn2rUoHg6Bk7EeVUm40Jny6ZAPcYRnDnrVltFHyJVG6Xq');
insert into codewars.user(id, da, password) values (120, '2136072', '$2y$10$cWRgiyDePtT5bwnLQdNJ8e.7ZQmMW1xrF39vZ.SbKZMVA3hk/cuq6');
insert into codewars.user(id, da, password) values (121, '2154718', '$2y$10$s4KUaUt/LMoRfcfZH3TBte/vU1fhzzSytFc4Du.7bmNX.jJGMcb9O');
insert into codewars.user(id, da, password) values (122, '2183098', '$2y$10$l18selpmua84ZKilj1P1ZucHgNXoaIW7NDFCKSehf5AkHAPLavnAy');
insert into codewars.user(id, da, password) values (123, '6176553', '$2y$10$9aen53CTgjpvrd76CMUHUOjMG2E6HuHdylH5DJ4k8SfLiWiQzxoWu');
insert into codewars.user(id, da, password) values (124, '1326333', '$2y$10$GWX5UqfKGz98U8Qx2rdnWuE3Pmbu.5gXu1tsCNsVq4nvPAbIt.I5q');
insert into codewars.user(id, da, password) values (125, '2178274', '$2y$10$SDduGbCGMaeZzzCiLpeO4.KOzbAiTs2SWvrEGPXKZyleiPzb/kVi6');
insert into codewars.user(id, da, password) values (126, '2146790', '$2y$10$ZRjjOCOdpG3HPxpLHqG/O.ut.7f3CDRj/bYkGjDpSIOdkmMzReHU2');
insert into codewars.user(id, da, password) values (127, '1929852', '$2y$10$5rozLkoLd4Rmeshi96bonuzyiNelNR94diVIUs9IkB2d2AY2jLuRq');
insert into codewars.user(id, da, password) values (128, '1538902', '$2y$10$5r4Hq6PKxdOkgJGhVIShXO94z8V0u8ItcTgC4hv2cuBxwjt0Ggc/S');
insert into codewars.user(id, da, password) values (129, '2144667', '$2y$10$xSEbVvmI6tNQLbBjiCD8Fu2M9xeVJJmma6CxhnbRWPbd8IH3UcbAm');
insert into codewars.user(id, da, password) values (130, '2167015', '$2y$10$V8fh2B/X8LXWesPX.s/ENOWpHOEVbidVa/Y05drDzzjV3sW9.S6qy');
insert into codewars.user(id, da, password) values (131, 'josh', '$2y$10$tc6fIxVZcKmSTHnPbnncLOkyssKCQg67f90lIjEnCZb/6Si1ve19u');
alter sequence codewars.user_id_seq restart with 132;

/*STUDENT*/
insert into codewars.teacher(da) values('dadajuice');
insert into codewars.student(id, da, team_id, cash, points) values (116, '2029684', 2, 3250, 130);
insert into codewars.student(id, da, team_id, cash, points) values (117, '1448676', 1, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (118, '6176471', 2, 2000, 80);
insert into codewars.student(id, da, team_id, cash, points) values (119, '2134218', 1, 1500, 60);
insert into codewars.student(id, da, team_id, cash, points) values (120, '2136072', 2, 500, 20);
insert into codewars.student(id, da, team_id, cash, points) values (121, '2154718', 1, 500, 20);
insert into codewars.student(id, da, team_id, cash, points) values (122, '2183098', 2, 500, 20);
insert into codewars.student(id, da, team_id, cash, points) values (123, '6176553', 1, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (124, '1326333', 2, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (125, '2178274', 1, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (126, '2146790', 2, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (127, '1929852', 1, 1000, 40);
insert into codewars.student(id, da, team_id, cash, points) values (128, '1538902', 2, 0, 0);
insert into codewars.student(id, da, team_id, cash, points) values (129, '2144667', 1, 500, 20);
insert into codewars.student(id, da, team_id, cash, points) values (130, '2167015', 2, 500, 20);
insert into codewars.student(id, da, team_id, cash, points) values (131, 'josh', 1, 0, 0);
alter sequence codewars.student_id_seq restart with 132;

insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (3, 1,'Mise à niveau -  Conversion de devise', 'Vous devez demander à l’utilisateur d’entrer un montant en dollars américains (USD) et votre programme doit fournir en sortie la conversion de ce montant en dollars canadiens (CAD). Vous devez également indiquer en sortie le taux qui a été utilisé. Prenez comme taux celui enregistré le 8 septembre 2015 en pleine récession (0.7579).', 1, 500, 20, 'Entrez le montant USD : 100
Conversion utilisant le taux 0.7579
Le montant CAD est 131,94$');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (8, 1,'Mise à niveau -  Consommation d''essence', 'Vous devez écrire un programme qui calcule la consommation de litre au 100km et le prix moyen au 100km. Vous demandez à l’utilisateur  d’entrer le nombre de kilomètres parcourus, le nombre de litres consommés ainsi que le prix d''un litre à la pompe. Le programme doit afficher la consommation de litre au 100km et le total de cette consommation.', 1, 500, 20, 'Entrez le nombre de km parcourus : 687
Entrez le nombre de litres consommés : 45.5
Entrez le montant d''un litre à la pompe : 1.15
Votre consommation au 100km est de 6.62L
Le cout estimé au 100km est de 7.62$
');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (19, 1,'Mise à niveau -  Échec ou succès', 'Vous devez écrire un programme qui demande à l’utilisateur de saisir sa note lors d’un examen et le programme affiche sa notation littérale (en lettre) suivant le barème suivant. Le programme affiche également une mention de l’apprentissage (excellent, très bien, bien, passage ou échec).
<br />
<table>
<tr>
<th>Appréciation</th>
<th>Notation</th>
<th>Pourcentages</th>
</tr>
<tr>
<td rowspan=""3"">Excellent</td>
<td>A+</td>
<td>95% - 100%</td>
</tr>
<tr>
<td>A</td>
<td>90% - 94%</td>
</tr>
<tr>
<td>A-</td>
<td>85% - 89%</td>
</tr>
<tr>
<td rowspan=""3"">Très bien</td>
<td>B+</td>
<td>82% - 84%</td>
</tr>
<tr>
<td>B</td>
<td>78% - 81%</td>
</tr>
<tr>
<td>B-</td>
<td>75% - 77%</td>
</tr>
<tr>
<td rowspan=""3"">Bien</td>
<td>C+</td>
<td>72% - 74%</td>
</tr>
<tr>
<td>C</td>
<td>68% - 71%</td>
</tr>
<tr>
<td>C-</td>
<td>65% - 67%</td>
</tr>
<tr>
<td rowspan=""2"">Passable</td>
<td>D+</td>
<td>62% - 64%</td>
</tr>
<tr>
<td>D</td>
<td>60% - 61%</td>
</tr>
<tr>
<td rowspan=""2"">Échec</td>
<td>E</td>
<td>0% - 59%</td>
</tr>
</table>', 1, 500, 20, 'Votre note : 85

A-
Excellent !');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (21, 1,'Mise à niveau -  Validation', 'Votre programme doit demander à l’utilisateur de faire un choix entre 1 et 10. Votre programme doit valider la valeur saisie de façon <b>robuste</b> ! C’est-à-dire que si on entre des lettres à la place d’un chiffre, le programme ne doit pas planter, mais donner une erreur significative.', 1, 500, 20, 'Votre choix (1-10) : batman
Votre choix est invalide !

Votre choix (1-10) : 15
Votre choix est invalide !');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (24, 1,'Mise à niveau -  Monnaie à rendre', 'Vous devez écrire un programme qui affiche la monnaie à rendre pour un montant d’argent tout comme une caisse enregistreuse. Vous devez demander à l’utilisateur de saisir le montant et le programme affiche le nombre de 2$, de 1$, de 25c, de 10c, de 5c et de 1c (même si le 1c n’est actuellement plus en circulation).', 1, 500, 20, 'Entrez un montant : 8,83
2$ : 4
1$ : 0
25c : 3
10c : 0
5c : 1
1c : 3');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (25, 1,'Mise à niveau -  Facture de base', 'Vous devez écrire un programme qui calcule simplement le montant des taxes au Québec. Vous devez demander à l’utilisateur de saisir un montant avant taxes et votre programme affiche le total de la TPS (5%), de la TVQ (9,975%) et le montant après taxes.', 1, 500, 20, 'Entrez le montant avant taxes : 100,00

TPS (5%) : 5,00$
TVQ (9,975%) : 9,98$
Total : 114,98$');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (28, 1,'Mise à niveau -  Âge depuis date', 'Vous devez écrire un programme qui permet de calculer l’âge d’un individu depuis sa date de naissance. Le programme demande d’entrer la date de naissance en trois étapes : l’année, le mois et le jour. Il affiche finalement l’âge calculé de l’individu en fonction de la date actuelle du système. Vous devrez utiliser l’objet Date (ou un équivalent) pour obtenir la date courante.', 1, 500, 20, 'Annee : 1988
Mois : 3
Jour : 11

Vous avez 27 ans !');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (31, 1,'Mise à niveau -  Jours dans un mois', 'Vous devez écrire un programme qui calcule le nombre de jours qu’il y’a dans un mois pour une année donnée. Votre programme demande de saisir l’année et ensuite le numéro du mois. Il affiche le nombre de jours pour le mois demandé. Vous devez tenir compte des années bissextiles. Voici la règle :
<br />
Une année est bissextile si l’année est divisible par 4 et non divisible par 100 ou si l’année est divisible par 400.
<br />
Une année bissextile fait en sorte qu’il y aura 366 jours dans une année au lieu de 365. La journée supplémentaire s’ajoute au mois de février qui passe de 28 jours à 29.
<br />
Vous devez respecter l''affichage exigé. C''est-à-dire que si le mois demandé est février, il faut afficher l''année dans la sortie, mais pas pour les autres mois. Il faut, par contre, toujours indiquer le mois sous forme textuelle dans la sortie.
', 1, 500, 20, 'Annee : 2015
Numéro du mois (1-12): 12
Le mois de decembre compte 31 jours

Annee : 2016
Numéro du mois (1-12): 2
Le mois de fevrier pour l''annee 2016 compte 29 jours

Annee : 2000
Numéro du mois (1-12): 10
Le mois de octobre compte 31 jours');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (32, 1,'Mise à niveau -  Réclamations', 'Vous devez écrire un programme qui calcule le montant d’une police d’assurance selon le nombre de réclamations dans l’année. Votre programme demande le montant de la prime initiale et le nombre de réclamations. Selon le nombre de réclamations, le montant de la prime augmente :
<br />
<table>
<tr>
<th>Nombre de réclamations</th>
<th>Pourcentage</th>
</tr>
<tr>
<td>0</td><td>2%</td>
</tr>
<tr>
<td>1</td><td>5%</td>
</tr>
<tr>
<td>2</td><td>8%</td>
</tr>
<tr>
<td>3</td><td>12%</td>
</tr>
<tr>
<td>4 et plus</td><td>On refuse le client !</td>
</tr>
</table>', 1, 500, 20, 'Montant initial: 100,00
Nb. reclamations: 2
Montant de la prime: 108,00$

Montant initial: 100,00
Nb. reclamations: 15
Desole ! Le client n''est plus assurable !');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (36, 1,'Mise à niveau -  Nombres pairs', 'Vous devez écrire un programme qui affiche simplement tous les nombres pairs de 100 à 200.', 1, 250, 10, '100, 102, 104, 106, 108, ..., 200');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (37, 1,'Mise à niveau -  Factorielle', 'Votre programme demande à l’utilisateur un entier et affiche la factorielle de ce nombre. Exemple, la factorielle de 5 égal 5 x 4 x 3 x 2 x 1 = 120.', 1, 500, 20, 'Entrez un nombre: 5

5! = 120');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (43, 1,'Mise à niveau -  Nombre premier', 'Vous devez écrire un programme qui détermine si un nombre saisi par l’utilisateur est premier. Un nombre est premier si son seul diviseur est lui-même et l’unité. Il suffit donc de diviser le nombre par 2,3,4,5,6 jusqu''à nombre – 1. Si aucun des restes trouvés n’est à 0, le nombre est donc premier.', 1, 750, 25, 'Entrez un nombre : 13

Ce nombre est premier !
');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (46, 1,'Mise à niveau -  HILO Game', 'Vous devez réaliser le jeu HILO. Ce jeu consiste à deviner un nombre généré aléatoirement par l’ordinateur. Ce nombre se trouve entre 1 et 100. L’utilisateur à droit à 10 essais. S’il réussit à trouver le nombre avant les 10 essais, un message de félicitation s’affiche. Sinon, le nombre caché et un message d’échec s’affichent et le programme se termine. Lorsque le nombre saisi par l’utilisateur est près de 5 du nombre caché, le programme affiche « vous brulez ! ».', 1, 500, 20, 'Essai #1: 3
Mauvaise réponse
Essai #2: 90
Mauvaise réponse
Essai #3: 75
Vous brulez !
Essai #4: 76
Vous brulez !
Essai #5: 77
BRAVO ! Vous avez trouve le nombre cache');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (50, 1,'Mise à niveau -  Générateur de billets', 'Vous devez écrire un programme qui génère de façon aléatoire une certaine quantité de codes de billet pour un événement quelconque. Ce code de billet doit être composé de 8 caractères aléatoires qui peuvent être soit des nombres ou des lettres majuscules. Le programme débute par demander le nombre de billets à générer. Le programme doit créer un fichier de sortie et inscrire un code de billet par ligne.', 1, 750, 25, 'Nombre de billets : 4
Terminé

// Dans le fichier ...
FG561DDP
1KLW5TVY
551GYVB2
DYB52ILM');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (51, 1,'Mise à niveau -  Âge moyen d''une cohorte', 'Vous devez écrire un programme qui permet de réaliser des statistiques sur la nouvelle cohorte du Cégep. Le programme demande de saisir le nombre d’étudiants et pour chacun, l’utilisateur doit saisir son âge. À la fin, le programme affiche la moyenne d’âge des étudiants ainsi que le nombre d’étudiants qui sont adultes.', 1, 500, 20, 'Nombre d''etudiants: 3

Age etudiant #1: 18
Age etudiant #2: 16
Age etudiant #3: 24

Moyenne d''age: 19 ans
Nb d''adultes: 2');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (54, 1,'Types primitifs', 'Vous devez concevoir un programme qui affiche à l''écran le minimum et le maximum de tous les types numériques primitifs (<code>byte</code>, <code>short</code>, <code>int</code>, <code>long</code>, <code>float</code> et <code>double</code>). Vous devez utiliser les constantes existantes et non pas écrire les nombres manuellement.', 1, 500, 20, 'Minimum du type &lt;byte&gt; : -128
Maximum du type &lt;byte&gt; : 127

Minimum du type &lt;short&gt; : -32768
Maximum du type &lt;short&gt; : 32767

Minimum du type &lt;int&gt; : -2147483648
Maximum du type &lt;int&gt; : 2147483647

Minimum du type &lt;long&gt; : -9223372036854775808
Maximum du type &lt;long&gt; : 9223372036854775807');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (55, 1,'Mise à niveau -  Fichier vers tableau', 'Vous devez concevoir un programme qui doit remplir un tableau selon des nombres contenus dans un fichier texte (1 nombre par ligne) qui se nomme <code>tableau.test</code>. Tenez pour acquis qu''il ne peut pas avoir plus de 255 lignes dans ce fichier. Une fois la lecture effectuée, vous devez afficher les éléments du tableau qui ont été chargés. Si le fichier n''existe pas, il faut afficher "Fichier introuvable !".', 1, 750, 25, '[1, 6, 8, 2, 90, 33, 9, 122, 2, 43]');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (56, 2,'Est-ce que la fin est le commencement ?', 'Vous devez programmer une fonction Java qui reçoit en paramètre un tableau d''entiers et qui retourne une valeur booléenne (VRAI ou FAUX) selon si le premier élément du tableau et le dernier sont identiques. Vous devez afficher, avant l''appel de votre fonction, les éléments du tableau et par la suite le résultat qu''a retourné votre fonction.', 1, 750, 25, '[1, 2, 5, 7, 33, 2, 21, 1]
VRAI

[72, 1, 2, 66, 32, 72]
VRAI

[9, 33, 2, 18, 21, 33, 90, 1]
FAUX');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (57, 2,'Une répétition dans le jardin zen', 'Vous devez programmer une fonction Java qui reçoit en paramètre un tableau d''entiers qui retourne un entier qui indique le nombre de valeurs différentes qui est répétée dans le tableau. Vous devez afficher le tableau avant l''appel de votre fonction et le résultat retourné par votre fonction.', 2, 850, 40, '[1, 1, 1, 2, 3, 4, 5, 6, 6]
2 valeur(s) r&#233;p&#233;t&#233;(s)

[4, 5, 6, 7, 8]
0 valeur(s) r&#233;p&#233;t&#233;(s)

[99, 76, 54, 32, 76]
1 valeur(s) r&#233;p&#233;t&#233;(s)');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (58, 1,'Le jeu du pendu, sans le pendu', 'Vous devez écrire un programme qui permet de jouer au pendu, sans le pendu. Vous devez chercher dans un fichier texte ordonné de façon séquentielle (1 mot par ligne) nommé <code>pendu.mots</code> un mot aléatoire qui sera le mot magique à deviner. Tenez pour acquis qu''il ne peut pas avoir plus de 255 lignes dans ce fichier.
<br />
Le joueur essaie une lettre à la fois et si la lettre est bien dans le mot magique, vous affichez la lettre à la bonne position.
<br />
Les lettres cachées sont représentées par un trait de soulignement (<i>underscore</i>). Le jeu s''arrête lorsque le mot a été trouvé. Si le fichier n''existe pas, il faut afficher <code>Fichier introuvable !</code>.', 2, 850, 40, 'Entrez une lettre : j
_ _ _ j _ _ _

Entrez une lettre : z
_ _ _ j _ _ _

Entrez une lettre : b
b _ _ j _ _ _

Entrez une lettre : o
b o _ j o _ _

Entrez une lettre : x
b o _ j o _ _

Entrez une lettre : r
b o _ j o _ r

Entrez une lettre : n
b o n j o _ r

Entrez une lettre : u
b o n j o u r');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (59, 2,'Avis de recherche', 'Vous devez programmer une fonction en Java qui effectue une recherche dans un tableau passé en paramètre pour une valeur quelconque. La fonction retourne une valeur booléenne (VRAI ou FAUX) selon si la valeur est bel et bien contenue dans le tableau. Vous devez afficher le tableau avant l''appel de votre fonction et le résultat retourné. Le nombre recherché doit être saisi au clavier.', 2, 750, 25, '[54, 33, 99, 93, 1, 4, 6]
Nombre recherch&eacute; : 99
VRAI

[54, 33, 99, 93, 1, 4, 6]
Nombre recherch&eacute; : 7
FAUX');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (60, 2,'La fusion des Titans', 'Vous devez programmer une fonction Java qui permet la fusion de deux tableaux d''entiers passés en paramètre. Votre fonction retourne le nouveau tableau résultant de la fusion des deux. Vous devez afficher les deux tableaux avant l''appel de votre fonction et le tableau fusionné après l''appel de votre fonction.', 2, 800, 35, '[1, 4, 5]
[7, 2, 9]
FUSION
[1, 4, 5, 7, 2, 9]

[1, 2, 3, 4]
[5, 6, 7, 8, 9, 10]
FUSION
[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (61, 2,'La différence des champions', 'Vous devez programmer une fonction Java qui permet de calculer la différence entre les deux plus grands nombres d''un tableau d''entiers passé en paramètre. Vous devez afficher le tableau avant l''appel de votre fonction et le résultat retourné.', 2, 850, 40, '[8, 5, 3, 4, 7, 7]
1

[90, 1, 2, 3, 90, 80, 23]
0

[2, 4, 5, 6, 9, 10, 54]
44');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (62, 2,'Inversion de tableau', 'Vous devez réaliser un programme Java qui comporte une fonction permettant d''inverser un tableau passé en paramètre par référence uniquement. C''est-à-dire qu''il ne faut pas utiliser de tableau temporaire pour l''inversion. Vous devez afficher le tableau avant et après l''appel de votre fonction.', 2, 850, 40, '[1, 2, 3, 4, 5, 6, 7]
[7, 6, 5 ,4 ,3 ,2 ,1]

[22, 33, 44, 55]
[55, 44, 33, 22]

[99, 22, 34, 1, 90, 100]
[100, 90, 1, 34, 22, 99]

[4, 3]
[3, 4]

[1]
[1]');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (63, 2,'Une paire de bas c''est mieux que rien !', 'Vous devez programmer une fonction Java qui retourne un tableau avec les valeurs PAIRES d''un tableau d''entiers passé en paramètre. Vous devez afficher le tableau avant l''appel de la fonction et afficher le tableau résultant.', 2, 850, 40, '[1, 5, 6, 7, 8, 10]
[6, 8, 10]

[3, 5, 7, 9, 11]
[]

[2, 4, 5, 6, 8, 10, 13]
[2, 4, 6, 8, 10]');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (64, 2,'Un peu plus de statistique', 'Vous devez programmer une fonction Java qui reçoit en paramètre un tableau d''entiers et qui affiche la moyenne, la médiane et le mode. Vous devez afficher, avant l''appel de votre fonction, les éléments du tableau.', 2, 950, 50, '[1, 4, 22, 34, 66, 99, 107]
Moyenne: 47,57
Médiane: 34,00
Mode: -

[1, 4, 22, 22, 34, 66, 99, 107]
Moyenne: 44,38
Médiane: 28,00
Mode: 22

[6, 6]
Moyenne: 6,00
Médiane: 6,00
Mode: 6');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (65, 2,'Tri par sélection', 'Il existe plusieurs façons de trier un tableau de données. À partir du pseudo-code fourni, vous devez implanter une fonction dans un programme Java qui permet de trier un tableau depuis l''algorithme du tri par sélection. Vous devez afficher le tableau avec les éléments non-triés et le tableau trié.
<br />
L''idée du tri par sélection est de chercher dans le tableau l''élément le plus petit et l''échanger avec le premier élément. Ensuite, on cherche le deuxième élément le plus petit et on l''échange avec le deuxième élément et on continue jusqu''à ce que le tableau soit entièrement trié.
<br />
<span style=""font-family: ''Courier New'', Courier, monospace;"">
proc&eacute;dure tri_selection(tableau t, entier n)<br />
pour i de 1 &#224; n - 1<br />
min &#8592; i<br />
pour j de i + 1 &#224; n<br />
si t[j] < t[min], alors min &#8592; j<br />
si min &#8800; i, alors &#233;changer t[i] et t[min]<br />
</span>', 3, 1700, 100, 'Non-trié: [8, 4, 2, 6, 5]
Trié: [2, 4, 5, 6, 8]

Non-trié: [1, 2, 3, 4, 5]
Trié: [1, 2, 3, 4, 5]

Non-trié: [12, 5, 4, 4, 9]
Trié: [4, 4, 5, 9, 12]');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (66, 1,'Mise à niveau -  Table de multiplication', 'Vous devez concevoir un programme qui affiche la table de multiplication de 1 à 10. Vous devez construire cette table en utilisant des boucles et un calcul arithmétique. Simplement écrire la table avec des <i>print</i> ne sera pas accepté. Vous pouvez avoir un affichage différent.', 1, 500, 20, ' 1 |     1    2    3    4    5    6    7    8    9    10
 2 |     2    4    6    8   10   12   14   16   18    20
...');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (67, 2,'L''extrême addition de deux nombres', 'Vous devez concevoir un programme qui effectue l''addition de deux nombres entiers. L''utilisateur entre les deux nombres au clavier et le programme doit afficher le résultat du calcul. <u>La partie intéressante est que votre programme doit prévoir les débordements lors du calcul</u>. S''il y a en effet débordement dans le calcul, vous devez afficher <code>Débordement !</code>.
<br />
Vous devez <b>ABSOLUMENT</b> utiliser le type <i>int</i> pour les variables du programme qui effectuent le calcul et qui garde en mémoire les valeurs saisies.  ', 3, 1700, 100, 'Entrez la première opérande : 10
Entrez la seconde op&eacute;rande : 5
10 + 5 = 15

Entrez la premi&egrave;re op&eacute;rande : 2147483647
Entrez la seconde op&eacute;rande : 1
D&eacute;bordement !

Entrez la premi&egrave;re op&eacute;rande : -2147483648
Entrez la seconde op&eacute;rande : -1
D&eacute;bordement !

Entrez la premi&egrave;re op&eacute;rande : -2147483648
Entrez la seconde op&eacute;rande : 2147483647
-2147483648 + 2147483647 = -1

Entrez la premi&egrave;re op&eacute;rande : -2147483648
Entrez la seconde op&eacute;rande : 0
-2147483648 + 0 = -2147483648

Entrez la premi&egrave;re op&eacute;rande : 0
Entrez la seconde op&eacute;rande : 0
0 + 0 = 0

Entrez la premi&egrave;re op&eacute;rande : -2147483648
Entrez la seconde op&eacute;rande : -9400
D&eacute;bordement !');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (68, 2,'Conversion binaire', 'Vous devez concevoir un programme qui fait la conversion d''un nombre binaire (base 2) vers sa représentation décimale (base 10). Vous n''avez pas à gérer les erreurs de saisie.', 1, 750, 25, 'Entrez un nombre dans le format binaire : 101
5

Entrez un nombre dans le format binaire : 10010101
149

Entrez un nombre dans le format binaire : 010101100001
1377');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (69, 3,'Dolorama Express', 'Vous devez réaliser un programme Java qui sera implanté dans les caisses de la chaîne de magasins Dolorama. Votre programme demande à l''utilisateur d''entrer une succession d''articles pour un client et ensuite d''afficher le total (avec les taxes) à l''écran.
<br />
Tout d''abord, le programme demande le prix de l''article en sélectionnant un choix parmi les suivants : 1$; 1,25$; 1,50$; 2$ (souvenez-vous que nous sommes au Dolorama).
<br />
Ensuite, le programme demande d''entrer la quantité pour cet article. Une fois fait, le programme demande à l''utilisateur s''il veut entrer un autre article. Si oui, on recommence depuis le début en conservant le sous-total actuel. Lorsque l''utilisateur a terminer d''entrer les articles, le sous-total, la TPS, la TVQ et le grand total sont affichés et le programme se termine.
<br />
<b>ATTENTION !</b> La solution doit être objet et être faite en utilisant une seule classe (autre que celle qui contient le Main). Une solution procédurale sera automatiquement refusée. ', 2, 1500, 75, 'Quel est le prix (1) 1$ | (2) 1,25$ | (3) 1,50$ | (4) 2$ ? 1
Quel est la quantité ? 4
Voulez-vous entrer un autre article (O / N) ? N

Sous-total : 4,00$
TPS : 0,20$
TVQ : 0,40$
Grand-total : 4,60$



Quel est le prix (1) 1$ | (2) 1,25$ | (3) 1,50$ | (4) 2$ ? 3
Quel est la quantité ? 2
Voulez-vous entrer un autre article (O / N) ? O
Quel est le prix (1) 1$ | (2) 1,25$ | (3) 1,50$ | (4) 2$ ? 1
Quel est la quantité ? 5
Voulez-vous entrer un autre article (O / N) ? N

Sous-total : 8,00$
TPS : 0,40$
TVQ : 0,80$
Grand-total : 9,20$');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (70, 2,'Le nombre de mots est important', 'Vous devez écrire un programme qui permet de compter le nombre de mots dans une chaîne de caractères saisie par l''utilisateur. Seuls les espaces permettent de délimiter deux mots dans ce contexte.', 1, 500, 20, 'Entrez une chaîne : Christopher Nolan a réalisé la trilogie Dark Knight
8 mot(s) trouvé(s)

Entrez une chaîne : Dario Argento a réalisé Suspira
5 mot(s) trouv&eacute;(s)

Entrez une chaîne : Poker
1 mot(s) trouvé(s)

Entrez une chaîne : Programmation orientée-objet
2 mot(s) trouvé(s)');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (71, 3,'Console IO', 'Vous devez programmer un simulateur pour une console virtuelle de base qui implémente uniquement certaines fonctionnalités de IO. Votre programme demande la saisie d''une commande et l''exécute. Si la commande n''existe pas, vous devez afficher le message ""Commande non reconnue"". Après l''exécution d''une commande, le programme redemande une commande jusqu''à ce que l''utilisateur utilise la commande ""<i>exit</i>"". Le répertoire racine de votre console virtuelle est le répertoire du projet. Voici la liste des commandes qui doivent être implémentée :
<br />
<i>exit</i> : termine le programme.
<br />
<i>cd</i> [répertoire ou ..] : si l''argument de la commande est "".."", il remonter d''un niveau. Sinon, il faut vérifier que le répertoire existe et entrer dedans.
<br />
<i>pwd</i> : afficher à l''écran le chemin actuel de l''utilisateur.
<br />
<i>ls</i> : afficher la liste des fichiers et répertoires dans le dossier actuel.
<br />
<i>mkdir</i> [nom du répertoire] : création d''un répertoire avec le nom passé en argument.
<br />
<i>touch</i> [nom du fichier] : création d''un fichier vide avec le nom passé en argument.
<br />
<b>ATTENTION !</b> La solution doit être objet. Une solution procédurale sera automatiquement refusée.', 4, 3000, 120, '> mkdir test
Répertoire &lt;test&gt; créé avec succès.
> cd test
> touch 1.txt
Fichier &lt;1.txt&gt; créé avec succès.
> touch 2.txt
Fichier &lt;2.txt&gt; créé avec succès.
> touch 3.txt
Fichier &lt;3.txt&gt; créé avec succès.
> ls
1.txt 2.txt 3.txt
> mkdir un_dossier
Répertoire &lt;un_dossier&gt; créé avec succès.
> ls
1.txt 2.txt 3.txt un_dossier
> pwd
/test/
> cd ..
> pwd
/
> ls
test
> exit');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (72, 3,'Analyse HTTP I', 'Vous devez écrire un programme qui permet de saisir une adresse Web (URL) sous le protocole HTTP standard et d''obtenir les informations qui sont contenues dans l''entête de la réponse HTTP d''une requête envoyée au serveur ciblé.
<br />
Vous pouvez utiliser les classes ""URL"" et ""URLConnection"" ou encore la classe ""Socket"". Vous pouvez utiliser d''autres classes selon vos besoins, mais les classes ""URL"" et ""URLConnection"" risquent d''être les plus simples d''utilisation. Vous devez afficher toutes les informations qui se retrouvent dans l''entête de la réponse HTTP.
<br />
ATTENTION ! La solution doit être objet. Une solution procédurale sera automatiquement refusée.', 2, 850, 40, 'Entrez une adresse valide : http://google.ca
HTTP/1.1 200 OK
alt-svc:quic=""www.google.com:443""; ma=2592000; v=""30,29,28,27,26,25"",quic="":443""; ma=2592000; v=""30,29,28,27,26,25""
alternate-protocol:443:quic,p=1
cache-control:private, max-age=0
content-encoding:gzip
content-type:text/html; charset=UTF-8
date:Mon, 08 Feb 2016 16:04:05 GMT
expires:-1
server:gws
x-frame-options:SAMEORIGIN
x-xss-protection:1; mode=block');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (73, 2,'CAPS LOCK', 'Vous devez écrire un programme qui permet de prendre une chaîne de caractères saisie par l''utilisateur et de la réécrire en majuscule sans espace inutile (les espaces au début et en fin de chaîne).', 1, 500, 20, 'Entrez une chaîne : vive LE beau Soleil
VIVE LE BEAU SOLEIL

Entrez une chaîne : coucou
COUCOU

Entrez une chaîne : batman est le meilleur
BATMAN EST LE MEILLEUR

Entrez une chaîne : Java 7
JAVA 7

Entrez une chaîne : école
ÉCOLE');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (74, 3,'Avant de mourir, on voit le cercle', 'Programmez une classe ""Cercle"" qui contient comme propriété son rayon et l''unité (par défaut à cm). Cette classe doit offrir trois services : afficher l''air du cercle, afficher le périmètre du cercle et assigner l''unité à utiliser (limité à mm, cm, dm et m). De plus, le rayon du cercle doit être donné au constructeur de la classe.
<br />
Utilisez ensuite votre classe depuis le main. Ne faite pas de lecture au clavier, faites vos tests directement dans le code. ', 3, 1800, 80, '// Utilisation dans le main
Cercle cercle = new Cercle(15);
cercle.afficherPerimetre();
cercle.afficherAir();

Cercle cercle = new Cercle(15);
cercle.setUnite(""mm"");
cercle.afficherPerimetre();
cercle.afficherAir();


');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (75, 3,'Un point dans l''univers', 'Vous devez programmer une classe ""Point"" qui contient deux propriétés : x et y. Vous devez créer des accesseurs et des mutateurs pour ces deux propriétés. Vous devez ajouter un mutateur ""setXY(int x, int y)"" qui permet d''assigner les deux valeurs d''un seul coup.
<br />
Votre classe doit offrir le service ""calculerDistance"" qui prend en argument un autre point. Cette méthode doit retourner la distance entre les deux points.
<br />
Consultez le lien suivant pour la formule de distance : <a href=""https://fr.wikipedia.org/wiki/Distance_entre_deux_points_sur_le_plan_cart%C3%A9sien"" target=""_blank"">Wikipédia</a>. Utilisez ensuite votre classe depuis le main. Ne faite pas de lecture au clavier, faites vos tests directement dans le code.
', 3, 1800, 80, '// Utilisation dans le main
Point a = new Point();
a.setXY(100, 100);

Point b = new Point();
b.setXY(50, 200);

System.out.println(""Distance : "" + a.calculerDistance(b));');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (76, 3,'Triangle des bermudes', 'Vous devez programmez une classe ""Triangle"" qui contient comme propriété les trois points du triangle. VOUS DEVEZ ABSOLUMENT UTILISER LA CLASSE POINT DEPUIS L''EXERCICE « <a href=""http://starwars.cegeplabs.qc.ca/missions/75"" target=""_blank"">Un point dans l''univers</a> ».
<br />
Votre classe doit implémenter un getter et un setter pour chaque point et offrir un mutateur qui permet d''assigner les 3 points d''un seul coup.
<br />
Votre classe doit offrir une méthode qui calcul le périmètre du triangle ainsi que l''aire (utilisez la distance entre les points). Vous devez également offrir un service qui permet d''afficher le type du triangle (équilatéral [tous les côtés sont égaux], scalene [deux des trois côtés sont égaux] ou isocèle [aucun côté égal]).
<br />
Consultez le <a href=""http://www.comment-calculer.net/aire-du-triangle.php"" target=""_blank"">lien suivant</a> pour la formule d''aire d''un triangle indépendamment des angles. Utilisez ensuite votre classe depuis le main. Ne faite pas de lecture au clavier, faites vos tests directement dans le code.', 4, 2500, 90, '// Utilisation dans le main
Point p1 = new Point();
Point p2 = new Point();
Point p3 = new Point();
p1.setXY(0, 0);
p2.setXY(0, 10);
p3.setXY(20, 0);

Triangle triangle = new Triangle();
triangle.setPoints(p1, p2, p3);
double perimetre = triangle.calculerPerimetre();
double aire = triangle.calculerAir();

triangle.afficherType();
System.out.println(""Périmètre: "" + perimetre);
System.out.println(""Aire: "" + aire);');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (77, 3,'Une forme générale', 'Vous devez programmer une classe ""FormeGeometrique"" qui contient un ensemble de points qui forme sa structure. Par exemple, si nous voulons un hexagone, nous allons insérer 6 points. VOUS DEVEZ ABSOLUMENT UTILISER LA CLASSE POINT DEPUIS L''EXERCICE « <a href=""http://starwars.cegeplabs.qc.ca/missions/75"" target=""_blank"">Un point dans l''univers</a> » comme base, <b>MAIS</b> modifiez-la de sorte à ce que le constructeur prenne en argument les coordonnées X et Y.
<br />
Votre classe doit permettre d''ajouter des points sur demande et permet simplement le calcul du périmètre. Utilisez ensuite votre classe depuis le main. Ne faite pas de lecture au clavier, faites vos tests directement dans le code.', 3, 1800, 80, '// Utilisation dans le main
Point p1 = new Point(0, 20);
Point p2 = new Point(20, 20);
Point p3 = new Point(30, 10);
Point p4 = new Point(20, 0);
Point p5 = new Point(0, 0);
Point p6 = new Point(-10, 10);

FormeGeometrique hexagone = new FormeGeometrique();
hexagone.ajouterPoint(p1);
hexagone.ajouterPoint(p2);
hexagone.ajouterPoint(p3);
hexagone.ajouterPoint(p4);
hexagone.ajouterPoint(p5);
hexagone.ajouterPoint(p6);
double perimetre = hexagone.calculerPerimetre();

System.out.println(""Périmètre: "" + perimetre);');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (78, 3,'Le temps dans une bouteille I', 'Vous devez programmer une classe ""Time"" qui contient les propriétés suivantes : heures (version 24 heures), minutes et secondes. Vous devez offrir un accesseur et un mutateur pour les 3 propriétés ainsi qu''un constructeur qui prend les 3 données en argument. Ajouter également un constructeur par défaut qui initiale le temps actuel. ATTENTION ! Vous devez faire en sorte que les setters soient valide. C''est-à-dire que si la donnée entrée est invalide vous devez conserver 0 (ex. 25 pour le nombre d''heures).
<br />
Vous devez programmer des méthodes qui permettent de retourner une nouvelle instance de Time depuis un objet Time. Les méthodes sont : nextHour, nextMinute, nextSecond, previousHour, previousMinute et previousSecond. Ses méthodes prennent un argument qui indique le nombre à avancer ou à reculer. Par exemple, nextHour(4) retournera un objet ""Time"" avancé de 4 heures.
<br />
Finalement, écrivez une méthode ""afficher"" qui affiche à la console le temps de l''objet sous le format suivant : hh:mm:ss (ex. 17:34:06).
<br />
ATTENTION ! Vous ne devez pas utiliser de classe Calendar ou Date ou tout autre classe déjà existante qui manipule le temps. Vous devez programmer l''ensemble de la logique.', 4, 2800, 90, '// UTILISATION DANS LE MAIN
Time t1 = new Time(10, 10, 00);
t1.afficher(); // Affiche 10:10:00

Time t2 = t1.nextHour(5);
t2.afficher(); // Affiche 15:10:00

Time t3 = t2.nextMinute(55);
t3.afficher(); // Affiche 16:05:00

');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (79, 4,'Netflix', 'Terminer l''application Netflix débuté collectivement en classe tel que demandé dans l''énoncé disponible sur LÉA.', 3, 1800, 80, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (80, 4,'Bibliothèque (diagramme UML)', 'Vous devez réaliser le diagramme de classes UML pour représenter la situation suivante. Vous n''avez pas à écrire les classes Java. Votre diagramme doit contenir toutes les associations nécessaires, toutes les généralisations nécessaires (l''héritage) et le type des propriétés (ainsi que l''accessibilité) doit être énoncé.
<br />
Vous devez concevoir un diagramme de classes en vue de la production d''un système informatisé de location de livres à la bibliothèque.
<br />
Pour qu''une personne puisse emprunter un livre, elle doit être membre de la bibliothèque. Les membres sont créés par un employé de la bibliothèque et exigent les propriétés suivantes : nom, prénom, adresse et numéro de téléphone. Un membre peut emprunter un maximum de 5 livres (qu''il a en sa possession en même temps).
<br />
La bibliothèque veut offrir un système de recherche de livre à l''accueil. Un livre doit donc avoir les propriétés suivantes : titre, année de publication, éditeur, ISBN, nom et prénom de l''auteur. D''ailleurs, il faudrait être en mesure de rechercher un auteur dans le système pour obtenir la liste de ses livres publiés.
<br />
Finalement, le système doit prévoir un accès pour les employés. Les employés sont caractérisés par un nom, un prénom, un numéro d''employé et une date d''embauche. Les employés peuvent ajouter dans le système des auteurs, des livres et des membres.', 3, 1500, 75, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (81, 4,'Clinique vétérinaire (diagramme UML)', 'Vous devez réaliser le diagramme de classes UML pour représenter la situation suivante. Vous n''avez pas à écrire les classes Java. Votre diagramme doit contenir toutes les associations nécessaires, toutes les généralisations nécessaires (l''héritage) et le type des propriétés (ainsi que l''accessibilité) doit être énoncé.
<br />
Vous devez concevoir un diagramme de classes en vue d''un système qui va permettre de gérer les rendez-vous d''une clinique vétérinaire.
<br />
Tout d''abord, le système doit permettre la gestion des clients. Un client est caractérisé par un nom, un prénom, une adresse et un numéro de téléphone. Un client peut avoir plusieurs animaux d''inscrits à la clinique.
<br />
Les animaux acceptés dans cette clinique sont les chats et les chiens seulement. Tous les animaux ont un nom, une race et une liste de maladies connues. Une maladie doit être représentée par un nom, une description des symptômes et une description du remède. Le système permettra d''effectuer des recherches dans la liste des maladies.
<br />
Finalement, le système doit permettre la création d''une rencontre. Une rencontre est caractérisée par une date, une description du problème et une description du diagnostic. Évidemment, une rencontre doit être associée avec un animal.

', 3, 1500, 75, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (82, 5,'Tim Horton (diagramme UML)', 'Vous devez réaliser le diagramme de classes UML pour représenter la situation suivante. Vous n''avez pas à écrire les classes Java. Votre diagramme doit contenir toutes les associations nécessaires, toutes les généralisations nécessaires (l''héritage) et le type des propriétés (ainsi que l''accessibilité) doit être énoncé.
<br />
Vous devez concevoir un diagramme de classes en vue d''un système de caisse pour les restaurants Tim Hortons. Votre système doit permettre l''achat des breuvages disponibles chez Tim Hortons.
<br />
Tout d''abord, il existe les breuvages chauds et il existe les breuvages froids. Dans la catégorie des breuvages chauds, il existe les cafés, les thés et les cafés spécialités (moka, latte, etc.). Dans la catégorie des breuvages froids, il existe les cappucinos glacés, les smooties et les limonades.
<br />
Tous les breuvages offrent les formats petit, moyen et grand. Les breuvages froids permettent l''ajout d''une saveur. Les cappucinos glacés permettent l''option d''ajouter de la crème. Les cafés offrent la possibilité d''ajouter des sucres, des crèmes ou des laits. Les cafés spécialisés ont simplement un type (moka, latte, etc.). Les thés offrent simplement une saveur de poche.
<br />
Tous les breuvages ont un prix de vente et une propriété qui permet de dire si le prix est en spécial ou non.
<br />
Votre système doit gérer la notion de commande. Une commande peut comporter plusieurs breuvages et conserve le mode de paiement (comptant, débit, crédit, etc.).', 4, 1800, 80, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (83, 5,'Ordinateurs', 'Vous devez réaliser des classes Java qui peuvent représenter les objets Ordinateur, Portable et Table. La classe Ordinateur contient les propriétés : modèle (ex. Macbook Pro), processeur (ex. 2.3GHz quad-core Intel Core i7), mémoire (ex. 8GB), espace disque (ex. 750 GB) et nombre de ports USB (ex. 3).
<br />
La classe Portable hérite de la classe Ordinateur et contient les propriétés suivantes : poids (ex. 1.7 lbs), dimension de l''écran (ex. 15'''') et capacité de la pile (ex. 7 heures).
<br />
La classe Table hérite de la classe Ordinateur et contient les propriétés suivantes : nombre de fentes d''expansion (ex. 3) et le style de boîtier (ex. Base).
<br />
Vous devez redéfinir la méthode toString pour permettre d''afficher directement les caractéristiques d''un ordinateur dans la situation d''un affichage par println (Macbook Pro 15'''' 2.3GHz quad-core Intel Core i7 8GB de RAM).
<br />
Vous devez écrire les trois classes Java et un main qui test vos classes (instancie chaque type et affiche les informations).', 2, 1500, 75, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (84, 5,'Usine d''animaux', 'Vous devez construire une architecture de classe qui permet d''instancier des animaux dans un programme main. Chaque animal devra implémenter les méthodes « parler » et « bouger » qui ne prennent aucun paramètre.
<br />
Les classes d''animaux que vous devez créer sont : Chien, Chat, Oiseau, Lion et Poisson. Ces classes devraient toutes être une spécialisation d''une certaine classe Animal ...
<br />
Dans le main, vous devez utiliser une classe de cette façon :
<br />
<i>
// Instanciation d''un chien<br />
Chien chien = new Chien();<br />
System.out.println(chien.parler());<br />
System.out.println(chien.bouger());
</i>
<br />
Le résultat à l''écran devrait être quelque chose comme : « Le chien parle avec Wooof ! » et « Le chien se déplace à quatre pattes ». Soyez inventif dans la façon de parler et de bouger des animaux. Vous devez simplement afficher des moyens différents pour chacun et indiquer la sorte d''animaux dans votre affichage.', 3, 1500, 75, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (85, 4,'ATM', 'Vous devez écrire un programme Java qui utilise des classes dans le but de réaliser un système de guichet monétaire (un ATM). Vous devez ABSOLUEMENT utiliser une classe « Compte » et une classe « Utilisateur » minimalement.
<br />
La classe Utilisateur contient un prénom, un nom, un ou plusieurs Compte (on peut imaginer un compte chèque et un compte épargne) et un NIP (4 caractères).
<br />
La classe Compte contient le nom du compte (épargne, chèque, etc.), le solde disponible et le maximum de retrait (par exemple 500$).
<br />
Votre programme demande tout d''abord d''entrer un NIP de 4 lettres (le NIP peut être affiché à l''écran de façon littérale sans les caractères invisibles *). Si le NIP est bon (c''est bel et bien un NIP existant dans un des objets Utilisateur de votre programme), vous offrez alors le choix à l''utilisateur de : retirer de l''argent, déposer de l''argent, voir l''état des comptes et quitter.
<br />
<b>Retirer de l''argent</b> : demande à l''utilisateur de choisir son compte en premier (il peut en avoir plusieurs !). Une fois le compte sélectionné, vous demandez à l''utilisateur d''entrer un montant et affiche le maximum qu''il peut retirer pour ce compte. Le montant entré par l''utilisateur doit être valide. S''il ne l''est pas, vous affichez un message d''erreur et recommencez l''opération. Si tout se passe bien, vous débitez le montant du compte de l''utilisateur et vous retournez au menu principal. Si l''utilisateur entre <termine>, il retourne au menu principal.
<br />
<b>Déposer de l''argent</b> : demande à l''utilisateur de choisir son compte en premier (il peut en avoir plusieurs !). Une fois le compte sélectionné, vous demandez à l''utilisateur d''entrer un montant. Le montant entré par l''utilisateur doit être valide. S''il ne l''est pas, vous affichez un message d''erreur et recommencez l''opération. Si tout se passe bien, vous ajoutez le montant indiqué dans le compte de l''utilisateur et vous retournez au menu principal. Si l''utilisateur entre <termine>, il retourne au menu principal.
<br />
<b>Voir l''état des comptes</b> : affiche le solde de tous les comptes de l''utilisateur et retourne au menu principal.
<br />
<b>Quitter</b> : retourne à l''écran de saisie du NIP.
<br />
Attention ! Tout affichage monétaire doit être formaté avec deux chiffres après la décimale.
<br />
Créez dans votre programme principal (le main) des objets Utilisateur que vous allez pouvoir tester.', 4, 3500, 150, 'NIP: 1234
-------------------------------
Bonjour Bruce Wayne,

1- Retirer
2- Déposer
3- État des comptes
4- Quitter

Votre choix: 1

Quel compte ?
1- Chèque
2- Épargne
3- Batcave

Votre choix: 3

Quel montant (retrait maximal de 7000.00$): 3000.00
OPÉRATION TERMINÉE

Bonjour Bruce Wayne,

1- Retirer
2- Déposer
3- État des comptes
4- Quitter

Votre choix: 3

Compte chèque: 325.00$
Compte épargne: 200.00$
Compte Batman: 27000.00$

Bonjour Bruce Wayne,

1- Retirer
2- Déposer
3- État des comptes
4- Quitter

Votre choix: 4

NIP: ');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (86, 4,'Batman v Superman orienté-objet', 'Vous devez réalisé l''énoncé complet du TP #1 (Tic-Tac-Toe Batman v Superman), mais en utilisant une solution orientée-objet. La qualité des classes et sujet à évaluation.', 5, 5000, 200, '');
insert into codewars.exercise(id, week_id, name, description, difficulty, cash_reward, point_reward, execution_exemple) values (87, 4,'Tic-Tac-Toe intelligent', 'Vous devez réaliser la mission bonus du TP #1 (Tic-Tac-Toe Batman v Superman), soit d''y intégrer un nouveau mode de jeu permettant de jouer contre l''ordinateur et d''y programmer une intelligence artificiel de base. L''IA ne doit pas faire uniquement des commandes aléatoires, il doit y avoir un "raisonnement" logique pour la plus part des actions.', 4, 3500, 150, '');

/*TIPS*/
insert into codewars.tips (id, exercise_id, tip, price) values (default, 3, 'Vous pouvez vérifier vos calculs depuis un <a href="http://www.banqueducanada.ca/taux/taux-de-change/convertisseur-de-devises-taux-du-jour/" target="_blank">convertisseur en ligne</a>. ', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 8, ' Attention ! les litres peuvent être flottant (avec une décimale).', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 25, ' Vous pouvez tester avec un <a href="http://www.calculconversion.com/calcul-taxes-tps-tvq.html" target="_blank">calculateur de taxes en ligne</a>. ', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 28, ' Utilisez l''objet Date de Java', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 36, 'Utilisez adéquatement une boucle for pour simplifier au maximum votre code.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 54, ' Référez-vous aux constantes incluses dans les Classes utilitaires de chaque type primitif (classe d''enrobage).', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 55, ' Utilisez une variable compteur pour savoir combien d''éléments ont été réellement lus depuis le fichier et chargés dans le tableau;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 55, ' Utilisez la classe Scanner pour effectuer votre lecture;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 55, ' Placez le fichier à la racine de votre projet Java.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 56, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 56, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 57, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 57, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 58, ' Charger tous les mots du fichier dans un tableau puis sélectionnez un indice au hasard dans ce tableau pour obtenir le mot à trouver;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 58, ' Utilisez une variable compteur pour savoir combien d''éléments ont été réellement lus depuis le fichier et chargés dans le tableau;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 58, ' Utilisez la classe <code>Scanner</code> pour effectuer votre lecture;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 58, ' Le fichier se trouve à la racine du projet Java;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 58, ' Utilisez la classe <code>Random</code> ou la méthode <code>Math.random()</code>.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 59, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 59, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 60, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 60, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 61, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 61, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 62, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 62, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 63, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 63, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 64, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 64, ' Si le tableau contient un nombre pair d''éléments, la médiane sera la moyenne des deux nombres du milieu;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 64, ' Vous pouvez utiliser la méthode printf pour gérer la précision de 2 chiffres après le point;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 64, ' Utilisez des variables de type double pour vos calculs.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 65, 'Effectuez une trace d''exécution sur papier pour bien comprendre l''algorithme avant de commencer à programmer;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 65, ' Utilisez des tableaux prédéfinis dans votre programme principal pour tester votre fonction;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 65, ' Faites-vous une fonction <code>afficherTableau</code> que vous pourrez réutiliser dans vos autres programmes nécessitant l''affichage d''un tableau.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 66, ' Utilisez la méthode <i>printf</i> pour effectuer un formatage clair.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 67, ' Testez dans un premier temps ce qui se produit lorsqu''il y a débordement.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 67, ' Prenez le temps d''analyser, sur papier, le résultat d''un calcul lorsqu''il y a un débordement.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 68, ' Il existe probablement quelque chose en Java qui permet de faire cette conversion en une ligne de code.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 69, ' Forcez-vous à faire une seule classe propre. Basez-vous sur l''exemple fait en classe.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 69, ' Vous pouvez consulter la page de revenu Québec pour le calcul de la taxe en fonction des paramètres de cette année : <a href="http://www.revenuquebec.ca/fr/entreprise/taxes/tvq_tps/calcul-taxes.aspx" target="_blank">www.revenuquebec.ca</a>.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 71, ' Créer une classe Console qui implémente les commandes. Garder une propriété qui conserve le répertoire courant (pwd) de l''utilisateur. Lorsque l''utilisateur se déplace avec la commande "cd", modifier simplement la propriété qui représente le répertoire courant (pwd).', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 72, ' Vous devrez utiliser le concept d''itérateur si vous utilisez la classe URLConnection;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 73, ' Utilisez les méthodes de la classe String.', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 82, ' Pensez à l''héritage !', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 84, 'Utilisez une classe parent Animal qui pourrait conserver le nom de la race;', 0);
insert into codewars.tips (id, exercise_id, tip, price) values (default, 84, 'Dans le constructeur de vos animaux, appeler le constructeur de votre classe parent et donnez-lui le nom de votre race.', 0);

/*ITEMS*/
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 9000, '+5 points sur le TP #1', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 20000, '+10 points sur le TP #1', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 10000, '+5 points sur le TP #2', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 25000, '+10 points sur le TP #2', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 10000, '+5 points sur le TP #3', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 25000, '+10 points sur le TP #3', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 18000, '+5 points sur l''examen de mi-session', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 45000, '+10 points sur l''examen de mi-session', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 10000, '+5 points sur le TP #4', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 25000, '+10 points sur le TP #4', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 10000, '+5 points sur le TP #5', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 26000, '+5 points sur l''examen final', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/trooper_helmet.png', 70000, '+10 points sur l''examen final', 'Points Bonus');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/lightsaber.png', 50000, 'Changer d''équipe', 'Équipes');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/medal.png', 25000, 'Multiplier par 1.5 les points actuels', 'Multiplicateur');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/medal.png', 50000, 'Multiplier par 2 les points actuels', 'Multiplicateur');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/medal.png', 750000, 'Multiplier par 2.5 les points actuels', 'Multiplicateur');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/medal.png', 100000, 'Multiplier par 3 les points actuels', 'Multiplicateur');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/dark_vador.png', 18000, 'Dévoilement d''une question de l''examen de mi-session', 'Questions D''examen');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 2000, 'Briser la limite de 100% pour le TP #1', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 6000, 'Briser la limite de 100% pour le TP #2', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 6000, 'Briser la limite de 100% pour le TP #3', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 6000, 'Briser la limite de 100% pour le TP #4', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 6000, 'Briser la limite de 100% pour le TP #5', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/millenium.png', 10000, 'Briser la limite de 100% pour le mi-session', 'Briseur de limite');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/star-wars.png', 4500, 'Obtenir un délai supplémentaire de 24h pour le TP #1', 'Délai Supplémentaire');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/star-wars.png', 7500, 'Obtenir un délai supplémentaire de 24h pour le TP #2', 'Délai Supplémentaire');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/star-wars.png', 7500, 'Obtenir un délai supplémentaire de 24h pour le TP #3', 'Délai Supplémentaire');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/star-wars.png', 8500, 'Obtenir un délai supplémentaire de 24h pour le TP #4', 'Délai Supplémentaire');
insert into codewars.item(id, image_path, price, description, name) values (default, '/assets/images/market_icons/star-wars.png', 8500, 'Obtenir un délai supplémentaire de 24h pour le TP #5', 'Délai Supplémentaire');

/*TRANSACTIONS*/
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 118, now(), 'Mise à niveau - Facture de base', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 118, now(), 'Mise à niveau - Échec ou succès', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 119, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 118, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 118, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Types primitifs', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Nombres pairs', 250, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Facture de base', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Échec ou succès', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 126, now(), 'Mise à niveau - Échec ou succès', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 129, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 121, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 130, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 127, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 125, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 126, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 123, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 122, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 120, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 119, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 117, now(), 'Mise à niveau - Conversion de devise', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 125, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 123, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 127, now(), 'Mise à niveau - Monnaie à rendre', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 124, now(), 'Mise à niveau - Consommation d''essence', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 124, now(), 'Mise à niveau - Âge depuis date', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 119, now(), 'Mise à niveau - Âge depuis date', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 117, now(), 'Mise à niveau - Âge depuis date', 500, 0, true, true);
insert into codewars.transaction(id, user_id, date, description, cash, points, is_cash_positive, is_points_positive) values (default, 116, now(), 'Mise à niveau - Âge depuis date', 500, 0, true, true);

/*SUBMISSION*/
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 46, true, false, '', '/home/codewars/www/code-wars/uploads/hmkY319iCOe6XB35JDLAvBEt.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 21, true, false, '', '/home/codewars/www/code-wars/uploads/ir3vf7nhJxX6hyi1ydfBT8Fj.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 32, true, false, '', '/home/codewars/www/code-wars/uploads/tqsl9HtmyYY9PhP9q2iJgPOv.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 66, true, false, '', '/home/codewars/www/code-wars/uploads/b8eNoNb4f8Mmo1AKynOWA4fC.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 24, true, false, '', '/home/codewars/www/code-wars/uploads/qSo8UzARYaahCuBfDJK0u2iI.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 51, true, false, '', '/home/codewars/www/code-wars/uploads/cvUW0LjhFGkBlZO0roV0uAMF.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 43, true, false, '', '/home/codewars/www/code-wars/uploads/reB5MVpgsB4fPziXSLeoQxuj.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 31, true, false, '', '/home/codewars/www/code-wars/uploads/udVR4CB7HupOIOR8GdZAveoe.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 37, true, false, '', '/home/codewars/www/code-wars/uploads/9l4IT0HVuTNlBPIiJ2Igv594.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1326333, 37, true, false, '', '/home/codewars/www/code-wars/uploads/gilgFboXYBWRWUXIzYe45BtI.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2146790, 21, true, false, '', '/home/codewars/www/code-wars/uploads/djlBKXjyaAGdMS4X5Qo46FEB.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1326333, 51, true, false, '', '/home/codewars/www/code-wars/uploads/D2b0O3s2gzvpj5A4m4Lc7qNo.zip', now(), 'Je fais de l''insomnie.', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1326333, 32, true, false, '', '/home/codewars/www/code-wars/uploads/AAuWzXBQv2c1fJBvpg3Pb0xt.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2167015, 21, true, false, '', '/home/codewars/www/code-wars/uploads/zwc6rhJG6MST2bFDtdhJdalv.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 50, true, false, '', '/home/codewars/www/code-wars/uploads/LDrKjvS2zcqBhSpCBNxQentf.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2167015, 36, true, false, '', '/home/codewars/www/code-wars/uploads/yDqzFjX7Fk403CLSpeq42gNu.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2167015, 66, true, false, '', '/home/codewars/www/code-wars/uploads/RNkuyq5oVrwwsPjtOsZZXCz1.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2167015, 51, true, false, '', '/home/codewars/www/code-wars/uploads/JIYMrWkaNk7HCYWoDrpARRba.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2146790, 25, true, false, '', '/home/codewars/www/code-wars/uploads/7Dy9QXWgBOnq5pQnb9bYexjv.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 19, true, false, '', '/home/codewars/www/code-wars/uploads/0PL8kVcaYJyRrpGRAnfk86Lq.java', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 21, true, false, '', '/home/codewars/www/code-wars/uploads/asfocZXVzsj2FUlUcpY2cs5a.java', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 24, true, false, '', '/home/codewars/www/code-wars/uploads/w0jCoi2gysx4Ta317k2N4bmn.java', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 25, true, false, '', '/home/codewars/www/code-wars/uploads/56bBZjKBuXmpx3xEZrPQIQ71.java', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 31, true, false, '', '/home/codewars/www/code-wars/uploads/aosflqlLPjunzehy0neEw6nf.java', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 19, true, false, '', '/home/codewars/www/code-wars/uploads/G6cI1sEaMqKpu2abUEkzDMuZ.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 24, true, false, '', '/home/codewars/www/code-wars/uploads/zQO7n5GjdKlXKksVpzqhb3BN.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 25, true, false, '', '/home/codewars/www/code-wars/uploads/WmQcAhlFKp0vVP9SoC5kaFhl.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 32, true, false, '', '/home/codewars/www/code-wars/uploads/3zUxyDBwB8MjaFqXMjwPI414.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 36, true, false, '', '/home/codewars/www/code-wars/uploads/bAHk7svNei3NySv0h4dPRIFg.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 37, true, false, '', '/home/codewars/www/code-wars/uploads/gORZZTk0trTzJLUvjXwG39T3.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 51, true, false, '', '/home/codewars/www/code-wars/uploads/qwdDMKuCluVcQtf3klfK5SeR.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 43, true, false, '', '/home/codewars/www/code-wars/uploads/K6RY6qXjRUoVzm9nQ7nExmfc.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 46, true, false, '', '/home/codewars/www/code-wars/uploads/SfZIw2GnjFEcyks6kHKWzO4F.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 50, true, false, '', '/home/codewars/www/code-wars/uploads/OzO2RaQKXchpDkMde5hjPc0W.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 66, true, false, '', '/home/codewars/www/code-wars/uploads/1uyM0KG4jwxh5yemAvVgORUF.zip', now(), '', null);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176471, 69, true, false, '', '/home/codewars/www/code-wars/uploads/kBRdQefL0ImqiLvnxvslE6C9.zip', now(), '', null);

insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176471, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2136072, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2154718, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2183098, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176553, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2178274, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2146790, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1929852, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2144667, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2167015, 3, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176471, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176553, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1326333, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2178274, 8, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 19, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176471, 19, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2146790, 19, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1929852, 24, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 25, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 6176471, 25, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 28, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1448676, 28, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2134218, 28, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2136072, 28, true, false, 'Pas si simple que ça ...', '', now(), '', false);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2183098, 28, true, false, 'Pas si simple que ça ....', '', now(), '', false);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 1326333, 28, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 36, true, true, '', '', now(), '', true);
insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date, student_comment, is_good) values(default, 2029684, 54, true, true, '', '', now(), '', true);
