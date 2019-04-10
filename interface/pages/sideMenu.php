<script src='/dojo/interface/pages/js/mail.js'></script>
<nav id="side-menu">
	<div id='mail-btn'>MAIL</div>
    <ul>
        <li id="deco-btn" class="menu-tab"><a href="../src/deconnect.php" text="deconnect">Deconnexion</a></li>
        <li id="retour-btn" class="menu-tab"><a href="./interface.php" text="retour">Retour</a></li>
        <li id="home" class="menu-tab" >Accueil</li>
        <li id="horaire" class="menu-tab" >Horaire</li>
        <li id="categ" class="menu-tab" >Section</li>
        <li id="disc" class="menu-tab" >Discipline</li>
        <li id="prof" class="menu-tab" >Profs</li>
        <li id="assoc" class="menu-tab" >Association</li>
		<li id='salle' class='menu-tab'>Location</li>
    </ul>
</nav>

<script>
$(document).ready(function(){

	$(".menu-tab").not("#retour-btn").on("click", function(){
		tabId = $(this).attr("id");
		activateTab(tabId);
	});

	$(".previ-btn").on("click", function() {
		$("#home-form").attr("action", "../../public/pages/home.php");
	});

	$("#side-menu ul li").on("click", function() {
		let id = $(this).attr("id");
		emptyContainer()
		emptyForm();
		setSession("nav-click", id);
		$("#container").attr("style","flex-direction:initial");
		switch (id) {
			case "home":
				displayModifForm("home");
			break;
			case "horaire":
				displayAddForm("horaire");
			break;
			case "assoc":
				getFormHTML(id, function(){
					$("#assoc-form-box").removeClass("undisplayed");
				});
			break;
			default: 
				getBox(id);
			break;
		}
	});
	//A FINIR
	function setSession(index, data) {
		$.ajax({
			url: "./ajax/setSession.php",
			dataType : "text",
			type : "POST",
			data : {'index': index, 'data': data },
			success : function(ret) {
				return (ret);
			}
		});
	}
});
</script>