# adventure
Construire un mini jeu d'aventure old-school rpg sous la forme d'une API.

# Livrables du 10/10/2021
Comme demandé dans le test, voici, selon moi, mes axes d'amélioration : 

1. Je n'ai pas réussi à implémenter les manager.
Je n'ai pas trouvé/compris comment faire dans la doc de Symfony. Actuellement avec Symfony 2.8, je passe par le service manager.yml mais j'ai l'impression que ce n'est plus le cas avec la version 4.4 ? Il y a un dossier Manager de créé avec une class. Mais je ne suis pas allée plus loin. Du coup, mon code se répète beaucoup dans les controller. 😕 Ça fait brouillon et ça me donne des boutons. 😬

2. Je n'ai pas réussi avec le serializer à formater une réponse en json. J'ai cette erreur : « Notice: Undefined variable: serializer »
J'ai alors opté pour des dump pour visualiser la réponse dans postman/insomnia. 

3. Lorsque mon entity A est joined à une entity B, je n'arrive pas à récupérer les valeurs de B. J'ai des null à la place. De souvenir, cela se passe dans le repository avec from/join. Mais la manière dont j'ai structuré mes tables, m'empêche de descendre en granularité. Soit c'est un soucis de structure soit de requête sql, soit ??? 🤔 

4. Après chaque requête sql, je récupère un array et pas l'instance. J’ai alors cette erreur : « Call to a member function addTile() on array ». Donc j'y accède via l'index. Exemple : $monster[0]. Dans le repository, j’ai remarqué cette déclaration :     //  * @return Tile[] Returns an array of Tile objects. 

5. À cause du point 4, je n'arrive pas à accéder au getter et au setter après une requête sql. Exemple : si j'ajoute une tile à une aventure, j' ai cette erreur : “Attempted to call an undefined method named "contains" of class "Proxies\__CG__\App\Entity\Tile".”

7. En comptant le setup de mon environnent de dev (chose à laquelle je ne suis pas rôdée), la compréhension du test et l’écriture du code, j’ai passé tout de même 12h. Très loin des 2h-4h annoncées. 🤯 Et malgré cela, je n'ai pas eu le temps de faire de doc technique, ni le random du chiffre obtenu au lancé de dés, ni certains call (character.rest, aventure.end).

8. J’ai choisi le langage Symfony pour effectuer ce test car c’est le langage de programmation orientée objet que j’utilise depuis 1 an. 
