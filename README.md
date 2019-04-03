Projet rapide de programmeurs rapides

CREATE TABLE movie_user_confirm (
    id SERIAL PRIMARY KEY,
    user_id int,
    confirm_code varchar,
    confirmed boolean
)
ALTER TABLE
--ONLY
public.movie_user
ADD email varchar(255)

ALTER TABLE
--ONLY
public.movie_user
ADD confirmed boolean
