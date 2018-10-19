<?php
  $pseudo = $_POST['valPseudo'];
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>NBA Reign</title>
  <link rel="stylesheet/less" type="text/css" href="style.less" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
  <script>
    function chargerSituations () {
      var request = new XMLHttpRequest();
      request.open("GET", "persistance/data.json", false);
      request.send(null);
      var json = JSON.parse(request.responseText);
      situations = json["situations"];
    };

    function setPercent(index, value) {
        var barre = document.getElementsByClassName("active")[index];
        var pourcentageActuel = barre.getAttribute("data-percent");
        var newPourcentage = parseInt(pourcentageActuel) + parseInt(value);
        if (newPourcentage > 100) { newPourcentage = 100; }
        else if (newPourcentage <= 0) {
          newPourcentage = 0;
          pourcentageNul = index;
        }

        barre.setAttribute("data-percent" , newPourcentage);
        barre.getElementsByClassName("bar")[0].style.width = newPourcentage + "%";
        barre.getElementsByClassName("progress")[0].innerHTML = newPourcentage + "%";
    };

    var numMatch = 1;
    var nbrSaisons = 1;
    var situations = new Array();
    var situationActuelle = new Array();
    var nouvelleSituation = new Array();
    var numSituation = 0;
    var alt;
    var pourcentageNul;
    chargerSituations();

    window.onload = function(){
      document.getElementById("question").innerHTML
      document.getElementById("question").innerHTML = situations[0]["question"];
      document.getElementById("imageSituation").src = situations[0]["img"];
      nouvelleSituation = situations[numSituation];
    };

    function repondre(typeRep) {
      alt = null;
      situationActuelle = nouvelleSituation;
      console.log(situationActuelle["non"]);
      if (typeRep == 0) {
        setPercent(0, - situationActuelle["notoriete"]);
        setPercent(1, - situationActuelle["reputation"]);
        setPercent(2, - situationActuelle["forme"]);
        setPercent(3, - situationActuelle["competences"]);
        setPercent(4, - situationActuelle["argent"]);
        if (situationActuelle["non"] !== null) {
          alt = 0;
        }
      } else {
        setPercent(0, situationActuelle["notoriete"]);
        setPercent(1, situationActuelle["reputation"]);
        setPercent(2, situationActuelle["forme"]);
        setPercent(3, situationActuelle["competences"]);
        setPercent(4, situationActuelle["argent"]);
        if (situationActuelle["oui"] !== null) {
          alt = 1;
        }
      }
      //situations.splice(numSituation, 1);
      if(pourcentageNul != null) {
        switch (pourcentageNul) {
          case 0:
            document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/xUySTIOsf7QxHx1gk0/giphy.gif'/> Qui êtes-vous ?";
            document.getElementsByClassName("content")[0].innerHTML = "T'as perdu à cause de ta notoriété. Même mon chien est plus connu. Tu veux recommencer ?";
          break;
          case 1:
            document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/zzdRbdk6cey1G/giphy.gif'/> Sale réputation !";
            document.getElementsByClassName("content")[0].innerHTML = "Ta réputation a mis fin à ta carrière. Retourne apprendre les bonnes manières ! Tu veux recommencer ?";
          break;
          case 2:
            document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/fQAxHCndAu4Vc3ii2r/giphy.gif'/> C'est pas la forme !";
            document.getElementsByClassName("content")[0].innerHTML = "Va te reposer, fais un régime mais fais quelque chose. Même ma grand mère cours plus vite. Tu veux recommencer ?";
          break;
          case 3:
            document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/O98wAWKi2Xo0o/giphy.gif'/> Incompétence, quand tu nous tiens !";
            document.getElementsByClassName("content")[0].innerHTML = "T'avais qu'à passé plus de temps à t'entraîner. Même le concierge était au gymnase plus souvent. Tu veux recommencer ?";
          break;
          case 4:
            document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/yIxNOXEMpqkqA/giphy.gif'/> No money, no problems ?";
            document.getElementsByClassName("content")[0].innerHTML = "T'as fait faillite, fallait pas te marier avec une gold digger. Tu veux recommencer ?";
          break;
        };
        $(".perdu").modal({
          onApprove : function() {
            window.location.hash = "index.html";
          },
          onDeny : function() {
            window.location.hash = "index.html";
          }
        }).modal("show");
      }
      
      console.log(situations.length);
      console.log(numSituation);
      if (numSituation == situations.length - 1) {
        document.getElementsByClassName("header")[0].innerHTML = "<img src='https://media.giphy.com/media/O6NvCZ9UViRXy/giphy.gif'/> YOU'RE A BEAST! YOU WIN!";
        document.getElementsByClassName("content")[0].innerHTML = "Tu as réussie ta carrière NBA, félicitations ! Tu es populaire, aimé et riche. Invité dans une émission TV, Shaquille O'neal t'es tombé dessus, tu es mort. Cordialement.";
        $(".perdu").modal({
          onApprove : function() {
            window.location.hash = "index.html";
          },
          onDeny : function() {
            window.location.hash = "index.html";
          }
        }).modal("show");
      }

      //numSituation = Math.floor(Math.random() * situations.length);
      if (alt == 0) { nouvelleSituation = situations[numSituation]["non"]; }
      else if (alt == 1) { nouvelleSituation = situations[numSituation]["oui"]; }
      else {
        numSituation++;
        nouvelleSituation = situations[numSituation];
      }

      document.getElementById("question").innerHTML = nouvelleSituation["question"];
      numMatch += 20;
      document.getElementById("matchSaison").firstChild.innerHTML = numMatch;
      if (numMatch > 82) {
        numMatch = 1;
        document.getElementById("matchSaison").firstChild.innerHTML = numMatch;
        document.getElementById("nbrSaisons").firstChild.innerHTML = ++nbrSaisons;
      }
      
      if (nbrSaisons == 1 && numMatch > 41) {
        document.getElementById("rewards").querySelector("img:first-of-type").style.display = "inline";
      }
    }
  </script>
</head>

<body>
  <section id="ecranJeu">
    <h1>NBA REIGN</h1>

    <article id="infosPersonnage">
      <div class="ui indicating progress active" data-percent="50">
            <div class="bar" style="width:50%;">
                
            </div>
            <div class="progress">50%</div>
            <div class="label">Notoriété</div>
      </div>
      <div class="ui indicating progress active" data-percent="50">
        <div class="bar" style="width:50%;">
            
        </div>
        <div class="progress">50%</div>
        <div class="label">Réputation</div>
      </div>
      <div class="ui indicating progress active" data-percent="50">
        <div class="bar" style="width:50%;">
            
        </div>
        <div class="progress">50%</div>
        <div class="label">Forme</div>
      </div>
      <div class="ui indicating progress active" data-percent="50">
        <div class="bar" style="width:50%;">
            
        </div>
        <div class="progress">50%</div>
        <div class="label">Compétences</div>
      </div>
      <div class="ui indicating progress active" data-percent="50">
        <div class="bar" style="width:50%;">
            
        </div>
        <div class="progress">50%</div>
        <div class="label">Argent</div>
      </div>
    </article>

    <article id="situation">
      <p id="question"></p>
      <img id="imageSituation" src=""/>
      <div id="choix">
          <button class="ui icon red deny inverted button" onclick="repondre(0)">
            <i class="remove icon"></i>
          </button>
          <button class="ui icon green ok inverted button" onclick="repondre(1)">
            <i class="checkmark icon"></i>
          </button>
        </div>
    </article>

    <article id="infosPartie">
      <div class="ui grid">
        <div class="eight wide column" id="nomJoueur"><?php echo $pseudo ?></div>
        <div class="eight wide column" id="matchSaison"><span>1</span> e match de la saison.</div>
        <div class="eight wide column" id="nbrSaisons"><span>1</span> e saison.</div>
        <div class="eight wide column" id="rewards">
          <img src="resources/icons/bronze-medal.png"/>
          <img src="resources/icons/silver-medal.png"/>
          <img src="resources/icons/gold-medal.png"/>
          <img src="resources/icons/bronze-badge.png"/>
          <img src="resources/icons/silver-badge.png"/>
          <img src="resources/icons/gold-badge.png"/>
          <img src="resources/icons/trophy.png"/>
          <img src="resources/icons/podium.png"/>
        </div>
      </div>
    </article>
  </section>

  <div class="ui perdu modal">
      <div class="ui icon header"></div>
      <div class="content"></div>
      <div class="actions">
        <div class="ui red deny inverted button">
          <i class="remove icon"></i>
          Non, de toute façon c'est cheaté
        </div>
        <div class="ui green ok inverted button">
          <i class="checkmark icon"></i>
          Je suis nul mais je vais réessayer
        </div>
      </div>
    </div>

</body>

</html>