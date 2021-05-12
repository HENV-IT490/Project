<?php
$host=$_SERVER['HTTP_HOST'];

echo'
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Search Ingredients</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer/">

    

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">
  </head>
  <body class="d-flex flex-column h-100"><link href="starter-template.css" rel="stylesheet">
  </head>
  <body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Recipe</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="Profile.html">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.html">Sign Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Recipe Search</h1>
    <p class="lead">Search up to 4 ingredients</p>
    <form class="d-flex" action="apiClient.php" method="GET">
      <input class="form-control me-2" type="search" name="ingredients" placeholder="ingredient1,ingredient2,ingredient3,ingredient4" aria-label="Search">
      <button class="btn btn-outline-success" type="submit" name="type" value="getRecipeList">Search</button>
    </form>
    </br>
    <p id="hist"></p>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http:gethatrecipe.com/Front/sessionValidate.js"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function(){
        var username=sessionStorage.getItem("username");
        $.post("dbClient.php", {type: "getHistory", username: username}, function(data){
          console.log(data);
          console.log(data.history[0].recipeID);
          console.log(data.history[0].recipeName);
          for(var i=0; i < data.history.length; i+=1)
          {
            //
            var baseURL="https://gethatrecipe.com/Front/recipe.php?recipeID="
            var recipeID = data.history[i].recipeID;
            var url = baseURL+recipeID;
            var recipeName = data.history[i].recipeName;
            console.log(url);
            $("<a/>").html(recipeName).attr("href",url).appendTo("#hist");
          }
        });
      });
    </script>

  </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">Place sticky footer content here.</span>
  </div>
</footer>


    
  </body>
</html>';

?>