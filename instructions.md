composer install --ignore-platform-reqs

php -S localhost:8000 -t public

INSERT INTO `goal_category` (`id`, `name`) VALUES (NULL, 'Travail'), (NULL, 'Santé'), (NULL, 'Social'), (NULL, 'Développement personnel'), (NULL, 'Finances'), (NULL, 'Loisir'), (NULL, 'Famille'), (NULL, 'Amis'), (NULL, 'Bien-être'), (NULL, 'Environnement');