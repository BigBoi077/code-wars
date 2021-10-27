/*team*/
insert into team(id, color, name) values (default, 'Red', 'Sith');
insert into team(id, color, name) values (default, 'Blue', 'Rebel');

/*insert student*/
insert into person(da, username, firstname, lastname, email) values (1111111, 'Joshua Leblanc', 'Joshua', 'Leblanc', 'leblancjoshua077@gmail.com');
insert into "user"(id, da, password) values(default, 1111111, '$2y$10$CJAhNUuCUlyUxWStg83nbuNK.Gpbd8o1nRLxnfwc47CwvLcIpgFBC');
insert into student(da, team_id, cash, points) values (1111111, 1, 0, 0);
insert into person(da, username, firstname, lastname, email) values (2222222, 'Jeremy Bouchard', 'Jérémy', 'Bouchard', 'leblancjoshua077@gmail.com');
insert into "user"(id, da, password) values(default, 2222222, '$2y$10$sqSDweGhocBtjzxkFqeNmeIksEdEIHCzv4zLA44yTk1Je0ZPJyfoi');
insert into student(da, team_id, cash, points) values (2222222, 1, 0, 0);
insert into person(da, username, firstname, lastname, email) values (3333333, 'Tommy-Lee Pigeon', 'Tommy-Lee', 'Pigeon', 'leblancjoshua077@gmail.com');
insert into "user"(id, da, password) values(default, 3333333, '$2y$10$ancZUqfr.TVoTV4g6UQvHOJlIWSbimuct5wxPACa0rN/LCWFKrH0C');
insert into student(da, team_id, cash, points) values (3333333, 2, 0, 0);
insert into person(da, username, firstname, lastname, email) values (4444444, 'Samuel Tessier', 'Samuel', 'Tessier', 'leblancjoshua077@gmail.com');
insert into "user"(id, da, password) values(default, 4444444, '$2y$10$UDJujooasG4snjI09wKDsehOVFXc7qsJv1rQz0ePZIQSNbLl55tja');
insert into student(da, team_id, cash, points) values (4444444, 2, 0, 0);

/*week*/
insert into week(id, number, start_date, is_active) values (default, 1, current_date, true);
insert into week(id, number, start_date, is_active) values (default, 2, current_date, true);

/*exercise*/
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 1, 'Les bases de Java', 'Hutt mon leia lando. Jar fett moff k-3po solo chewbacca. Kenobi k-3po wicket mandalorians organa utapau. Endor obi-wan organa sidious. Calrissian calamari amidala yoda. Yavin lando secura darth darth. Jango jawa skywalker bespin. Windu gonk skywalker boba. Darth calamari wookiee yoda palpatine. Organa ackbar solo skywalker fett jade. Thrawn sebulba mace binks solo sidious. Skywalker twi''lek windu maul vader kenobi antilles. Darth wicket sidious darth chewbacca kenobi moff. Ben mothma obi-wan lando.', 100, 1, '1 * 2 *** 3 ***** 4 ******* 5 ********', 10);
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 1, 'Calculatrice Spatiale', 'Hutt mon leia lando. Jar fett moff k-3po solo chewbacca. Kenobi k-3po wicket mandalorians organa utapau. Endor obi-wan organa sidious. Calrissian calamari amidala yoda. Yavin lando secura darth darth. Jango jawa skywalker bespin. Windu gonk skywalker boba. Darth calamari wookiee yoda palpatine. Organa ackbar solo skywalker fett jade. Thrawn sebulba mace binks solo sidious. Skywalker twi''lek windu maul vader kenobi antilles. Darth wicket sidious darth chewbacca kenobi moff. Ben mothma obi-wan lando.', 150, 2, '1 * 2 *** 3 ***** 4 ******* 5 ********', 15);
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 2, 'Conquérir Tatooine', 'Hutt mon leia lando. Jar fett moff k-3po solo chewbacca. Kenobi k-3po wicket mandalorians organa utapau. Endor obi-wan organa sidious. Calrissian calamari amidala yoda. Yavin lando secura darth darth. Jango jawa skywalker bespin. Windu gonk skywalker boba. Darth calamari wookiee yoda palpatine. Organa ackbar solo skywalker fett jade. Thrawn sebulba mace binks solo sidious. Skywalker twi''lek windu maul vader kenobi antilles. Darth wicket sidious darth chewbacca kenobi moff. Ben mothma obi-wan lando.', 200, 5, '1 * 2 *** 3 ***** 4 ******* 5 ********', 20);

insert into tips(id, tip, exercise_id) values (default, 'En cas de difficulté, veuillez vous référer à w3school.', 1);

/*items*/
insert into item(id, name, price, description) values (default, 'Point bonus', 1000, '1 points bonus au bulletin.');
insert into item(id, name, price, description) values (default, 'Assault sur ennemi', 500, '-100 points à l''équipe adverse.');

/*student item*/
insert into studentitem(id, item_id, student_da) values (default, 1, 1111111);
insert into studentitem(id, item_id, student_da) values (default, 1, 2222222);

