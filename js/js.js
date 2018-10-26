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
    var img = 0;
    chargerSituations();

    window.onload = function(){
      document.getElementById("question").innerHTML = situations[0]["question"];
      nouvelleSituation = situations[numSituation];

      var url_string = window.location.href;
      var url = new URL(url_string);
      var valPseudo = url.searchParams.get("valPseudo");
      document.getElementById("nomJoueur").innerHTML = valPseudo;
    };

    function repondre(typeRep) {
      alt = null;
      situationActuelle = nouvelleSituation;
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
      
      if (numMatch > 41) {
        document.getElementsByClassName("rewards")[img].style.display = "inline";
        img++;
      }
    }