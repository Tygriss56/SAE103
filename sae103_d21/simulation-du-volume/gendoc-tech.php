<?php
	// configuration
    $config = file("config");

	foreach($config as $ligne){
		$ligne = explode("=", $ligne);
		$tab_config[$ligne[0]] = trim($ligne[1]);
		$ligne = implode("=", $ligne);
	}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css" >
    </head>
    <body>
        <header>
            <img src="images/logo_iut.png">
            <h1>Documentation Technique</h1>
            <article>
                <h3>Client : <?php echo $tab_config["CLIENT"]; ?></h3>
                <h3>Produit : <?php echo $tab_config["PRODUIT"]; ?></h3>
                <h3>Version : <?php echo $tab_config["VERSION"]; ?></h3>
                <h3> <?php echo trim(shell_exec("date +\"%d / %m / %Y\"")); ?></h3>
            </article>
            <article>
                <h2>Table des matières</h2>
                <ul>
<?php
    $tab_nomFic = array_slice($argv, 1); 
    
	// table des matières
    foreach (range(1, $argc-1) as $indice ) {
?>
                    <a href="#s<?php echo $indice ?>"><li><?php echo $tab_nomFic[$indice-1]; ?></li></a>
                    <ul>
                        <a href="#<?php echo $indice ?>_def"><li>DEFINE</li></a>
                        <a href="#<?php echo $indice ?>_struc"><li>STRUCTURES</li></a>
                        <a href="#<?php echo $indice ?>_var"><li>VARIABLES GLOBALES</li></a>
                        <a href="#<?php echo $indice ?>_fonc"><li>FONCTIONS</li></a>
                    </ul>


<?php } ?>
            </article>
        </header>
        <main>
<?php
    foreach ($tab_nomFic as $nomFic ) {
    	$indice_nomFic = array_search($nomFic, $tab_nomFic)+1;
        $tab_fic = file($nomFic);
        
		// entete du fichier
        $tab_entete = array();
    
        if ( "/**" == trim($tab_fic[0]) ) {
    	    $indice = 1;
    	    while ( "*/" != trim($tab_fic[$indice]) ){
    		    $tab_entete[$indice-1] = substr($tab_fic[$indice], 4);
    		    $indice++;
    	    }
            $entete = implode("                    ", $tab_entete);
            
?>

            <section id="s<?php echo $indice_nomFic; ?>">
                <h1><?php echo $nomFic ?></h1>
                <p>
		    <?php echo $entete; ?>
                </p>
                <article id="<?php echo $indice_nomFic; ?>_def">
                    <h2>DEFINE</h2>
                    <div class="bloc">
<?php
			// define
            foreach ( $tab_fic as $ligne_fic ) {
            	$index = 0;
            	$index_space = 0;
            	if ( "#define" == substr($ligne_fic, 0, 7) ) {
            		$ligne_fic = substr($ligne_fic, 8);
            		
            		$ligne_fic = explode(" ", $ligne_fic);

            		$resultat_define = $ligne_fic[0];
            		$resultat_define .= " (" . trim($ligne_fic[1]) . ")";
            		unset($ligne_fic[0]);
			unset($ligne_fic[1]);
			unset($ligne_fic[2]);
			$ligne_fic = implode(" ", $ligne_fic);
			$ligne_fic = substr(trim($ligne_fic), 0, strlen($ligne_fic)-3);
			$resultat_define .= " : " . $ligne_fic;

?>
                        <p><?php echo $resultat_define;?></p>
<?php
            	}
            }
?>
                    </div>
                    
                </article>

                <article id="<?php echo $indice_nomFic; ?>_struc">
                    <h2>STRUCTURES</h2>
<?php
			// structures
            $trouve = false;
            $lecture_fini = false;
            $resultat_struct = array();
            $nom_typedef = ["int", "double", "float", "char" ];
            $indice_resultat = 1;
            foreach ( $tab_fic as $ligne_fic ) {
            	if ( $trouve ) {
            		if ( "}" == substr($ligne_fic, 0, 1) ) {
            			$trouve = false;
            			$lecture_fini = true;
            			
            			$resultat_ligne = explode(";",substr($ligne_fic, 2, strlen($ligne_fic)-1));
            			
            			$resultat_struct[0] = "Nom : " . $resultat_ligne[0];
            			$nom_typedef[count($nom_typedef)] = $resultat_ligne[0];
            			$resultat_struct[$indice_resultat] = "Detail : " . substr(trim($resultat_ligne[1]), 4, strlen(trim($resultat_ligne[1]))-6 );
            			$indice_resultat++;

            		} else {
            			$resultat_ligne = explode(";" ,trim($ligne_fic));
            			
            			$resultat_struct[$indice_resultat] = "Attribut " . $resultat_ligne[0] . " : ";
            			$resultat_struct[$indice_resultat] .= substr(trim($resultat_ligne[1]), 4,  strlen(trim($resultat_ligne[1]))-6);
            		}
            		$indice_resultat++;
            	}
            	if ( "typedef struct {" == trim($ligne_fic) ) {
            		$trouve = true;
            		$resultat_struct = array();
            		$indice_resultat = 1;
?>
                    <div class="bloc">
<?php
            	}
            	if ( $lecture_fini ) {
            		foreach ( range( 0, $indice_resultat -2 ) as $ligne ) {
?>                        <p><?php echo trim($resultat_struct[$ligne]); ?></p>
<?php
			}
			$lecture_fini = false;
?>
                    </div>
<?php
            	}
     	
            }
?>
                </article>

                <article id="<?php echo $indice_nomFic; ?>_var">
                
                    <h2>VARIABLES GLOBALES</h2>
                    <div class="bloc">
<?php
			// variables globales
            foreach ( $tab_fic as $ligne_fic ) {
            	$index = 0;
            	$index_space = 0;
            	if ( in_array(explode(" ", $ligne_fic)[0], $nom_typedef) && (strpos(explode(" ", $ligne_fic)[1], "(") === false)  ) {
            	
            		
            		$ligne_fic = explode(" ", $ligne_fic);

            		$resultat_variable = $ligne_fic[0];
            		$resultat_variable .= " " . $ligne_fic[1];
            		
            		if ( strpos($resultat_variable, ";") !== false ) {
            			$resultat_variable = substr($resultat_variable, 0, strlen($resultat_variable)-1 );
            		}
            		
 			unset($ligne_fic[count($ligne_fic)-1]);           		
            		unset($ligne_fic[0]);
			unset($ligne_fic[1]);

			
			$ligne_fic = implode(" ", $ligne_fic);
			$ligne_fic = substr($ligne_fic, strpos($ligne_fic, "/**")+3, strlen($ligne_fic));
			$resultat_variable .= " : " . $ligne_fic;

?>
                        <p><?php echo $resultat_variable;?></p>
<?php
            	}
            }
?>
                    </div>
                    
                </article>

                <article id="<?php echo $indice_nomFic; ?>_fonc">
                    <h2>FONCTIONS</h2>
<?php
		// fonctions
		$nom_typedef[count($nom_typedef)] = "void";	
			
		$trouve_details = false;
		
		
		$indice_resultat = 2;
        	foreach ( $tab_fic as $ligne_fic ) {

			if ( strpos($ligne_fic, "\\brief") !== false ) {
				
				// initialistion de resultat_fonction
				$resultat_fonction = array();

				$resultat_fonction["nom"] = "";				
				$resultat_fonction["brief"] = "";
				$resultat_fonction["param"] = array();
				$resultat_fonction["return"] = "";
				$resultat_fonction["details"] = array();
				
				// collecte des information de brief
				$ligne_fic = explode("\brief", $ligne_fic);
				unset($ligne_fic[0]);
				$resultat_fonction["brief"] = trim("Présentation : ".implode(" ", $ligne_fic));
				$ligne_fic = implode("\\brief", $ligne_fic);

			}
			
			elseif ($trouve_details) {
			
				if ( (strpos($ligne_fic, "\\") !== false) || (strpos($ligne_fic, "*/") !== false) ) {
					$trouve_details = false;
				}
				elseif ( trim($ligne_fic) == "*" )  {
					$resultat_fonction["details"][] = "";

				}
				else {
					$resultat_fonction["details"][] = substr($ligne_fic, 3, strlen($ligne_fic));
				}
			}
			if ( strpos($ligne_fic, "\\details") !== false ) {
				$trouve_details = true;
				$resultat_fonction["details"][] = "Details : ".substr($ligne_fic, strpos($ligne_fic, "\details")+8, strlen($ligne_fic));
			}
			elseif ( strpos($ligne_fic, "\\param") !== false ) {
				$resultat_fonction["param"][] = "Paramètre : ".substr($ligne_fic, strpos($ligne_fic, "\param")+6,strlen($ligne_fic));

			}
			
			elseif ( strpos($ligne_fic, "\\return") !== false ) {
				$resultat_fonction["return"] = "Délivre : ".substr($ligne_fic, strpos($ligne_fic, "\\return")+7,strlen($ligne_fic));
			}
			elseif ( in_array(explode(" ", $ligne_fic)[0], $nom_typedef) && (strpos(explode(" ", $ligne_fic)[1], "(") !== false) ) {
				$resultat_fonction["nom"] = "Nom : " . explode("(", explode(" ", $ligne_fic)[1])[0];

                        	
                        	// affichage des fonctions
                        	$annotation =  "				";
?>
                     <div class="bloc">
<?php

				// affichage des noms
				echo $annotation . "<p>" . trim($resultat_fonction["nom"]) . "</p>" . "\n";
				
				// affichage de brief
				echo $annotation . "<p>" . trim($resultat_fonction["brief"]) . "</p>" . "\n";
				
				
				// affichage des parametre
				
				foreach ( $resultat_fonction["param"] as $ligne ) {
					echo $annotation . "<p>" . trim($ligne) . "</p>" . "\n";
				}
				
				// affichage de return
				echo $annotation . "<p>" . trim($resultat_fonction["return"]) . "</p>" . "\n";
				
				// affichage des details
                        	$trouve_liste = false;
				foreach ( $resultat_fonction["details"] as $ligne ) {
					
					if ( (explode(" ",$ligne)[0] == "-") && !($trouve_liste) ) {
						$trouve_liste = true;
?>
                        <ul>
<?php
					}

					
					
					if ( $trouve_liste ) {
					
						if ( explode(" ",$ligne)[0] != "-" ) {
							$trouve_liste = false;
?>
                        </ul>
<?php	
						}
						else {
?>
                        	<li><?php echo trim(substr($ligne, 4, strlen($ligne))); ?></li>
<?php
						}
					}
					
					if ( $ligne == "" ) {
?>
                        <br>
<?php
					}
					
					elseif ( !$trouve_liste ){
						echo $annotation . "<p>" . trim($ligne) . "</p>" . "\n";
					}
					
				}
				
				if ( $trouve_liste ) {
					$trouve_liste = false;
?>
                        </ul>
<?php	
				}			
?>
                     </div>
<?php	
			}
			
		}
		
?>
                </article>
           </section>
<?php
        }
    }
?>
     </body>
</html>