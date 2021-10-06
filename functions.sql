create or replace function getPoints(fda varchar)
    returns int
    language plpgsql
as $$
begin
    select sum(e.point_reward) points from codewars.student s join codewars.studentexercise se on s.da = se.student_da join codewars.exercise e on e.id = se.exercise_id where s.da = fda
end; $$;