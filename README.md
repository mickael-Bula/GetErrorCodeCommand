# Comment arrêter un enchaînement de Commandes Symfony (Symfony\Component\Console\Application)

Cette petite application contient plusieurs Commandes qui peuvent être lancée individuellement :

```bash
$ php bin/migrate.php migration:one
$ php bin/migrate.php migration:two
$ php bin/migrate.php migration:three
```

>NOTE : ces commandes ne font rien d'autre qu'afficher un message en console et dans les logs. Elles ne sont ici qu'un prétexte.

Mais elles peuvent aussi être exécutées successivement à l'aide d'une seule commande :

```bash
$ php bin/migrate.php migration:tasks
```

Si une erreur survient au cours de l'exécution de l'une des commandes, la suivante est exécutée.
Or, il peut parfois être nécessaire de contrôler la bonne exécution d'un script avant de lancer le suivant, notamment lorsqu'ils dépendent les uns des autres.

Une vérification de ce type a donc été ajoutée dans le script enchaînant les commandes.
Elle consiste à simplement récupérer le code de retour à l'exécution d'une commande, de l'enregistrer dans un tableau, puis de terminer le processus si un code différent de 0 est obtenu.

## Comment tester

Une propriété `$error` a été ajoutée dans chacune des commandes. Il suffit de mettre cette propriété à `true` pour que la commande concernée retourne un code d'erreur.
