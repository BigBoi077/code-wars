/*team*/
insert into team(id, color, name) values (default, 'Red', 'Sith');
insert into team(id, color, name) values (default, 'Blue', 'Rebel');

/*insert student*/
insert into person(da, firstname, lastname) values (1111111, 'test1', 'damnSon');
insert into "user"(id, da, password) values(default, 1111111, '$2y$10$CJAhNUuCUlyUxWStg83nbuNK.Gpbd8o1nRLxnfwc47CwvLcIpgFBC');
insert into student(da, team_id, cash) values (1111111, 1, 0);
insert into person(da, firstname, lastname) values (2222222, 'test2', 'damnSon2');
insert into "user"(id, da, password) values(default, 2222222, '$2y$10$sqSDweGhocBtjzxkFqeNmeIksEdEIHCzv4zLA44yTk1Je0ZPJyfoi');
insert into student(da, team_id, cash) values (2222222, 1, 0);
insert into person(da, firstname, lastname) values (3333333, 'test3', 'damnSon3');
insert into "user"(id, da, password) values(default, 3333333, '$2y$10$ancZUqfr.TVoTV4g6UQvHOJlIWSbimuct5wxPACa0rN/LCWFKrH0C');
insert into student(da, team_id, cash) values (3333333, 2, 0);
insert into person(da, firstname, lastname) values (4444444, 'test4', 'damnSon4');
insert into "user"(id, da, password) values(default, 4444444, '$2y$10$UDJujooasG4snjI09wKDsehOVFXc7qsJv1rQz0ePZIQSNbLl55tja');
insert into student(da, team_id, cash) values (4444444, 2, 0);

/*week*/
insert into week(id, number, start_date, is_active) values (default, 1, current_date, true);
insert into week(id, number, start_date, is_active) values (default, 2, current_date, true);

/*exercise*/
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 1, 'java_basic', 'les base de java', 100, 1, 'nope', 10);
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 1, 'calculator', 'faire une calculatrice simple', 150, 2, 'nope', 15);
insert into exercise(id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward) values (default, 2, 'exemple3', 'faire une exemple 3', 200, 5, 'nope', 20);

insert into tips(id, tip, exercise_id) values (default, 'come on cest basique', 1);

/*items*/
insert into item(id, name, price, description) values (default, 'bonus points', 1000, '1 points bonus au bulletin');
insert into item(id, name, price, description) values (default, 'assault sur ennemi', 500, '-100 points bonus à lennemi');

/*student item*/
insert into studentitem(id, item_id, student_da) values (default, 1, 111111);
insert into studentitem(id, item_id, student_da) values (default, 1, 222222);