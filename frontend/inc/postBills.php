<?php
if (!empty($term)) {
$sql = "SELECT local_html, code, title FROM bills WHERE title LIKE '%".$term."%' ORDER BY id DESC LIMIT ?, ?";
} else {
		# Get the posts in that 'page'
		#$statement = $mysqli->prepare  ("SELECT * FROM bills ORDER BY id DESC LIMIT ?, ?");
    $sql = 'SELECT * FROM bills ORDER BY id DESC LIMIT ?, ?';
}
$stm = $pdo->prepare($sql);
$stm->bindParam(1, $page, PDO::PARAM_INT);
$stm->bindParam(2, $limit, PDO::PARAM_INT);
$stm->execute();
		 while ( $row = $stm->fetch() ) {
		 # And output one .post per database row :) 
			$voteBillConvert = str_replace("html", "json", $row['local_html']);
            $voteBillJson = file_get_contents("C:\Ampps\www\FourthBranch\FourthBranch\outside_resources\\".str_replace("/", "\\", $voteBillConvert));
			//$voteBillJson = file_get_contents("./cgi-bin/".$voteBillConvert);
			$voteBillJsonDecoded = json_decode($voteBillJson, true);
			$voteBillJsonSnippit = $voteBillJsonDecoded['summary']['text'];
			if (strlen($voteBillJsonSnippit) >= 317) {
				$pos = strpos($voteBillJsonSnippit, " ", 317);
			} else {
				$pos = 318;
			}
			if (strpos($voteBillJsonSnippit, "- ") == 0){
				$strpos = -2;
			} else {
				$strpos = strpos($voteBillJsonSnippit, "- ");
			}
			$voteBillDescSnippit = substr($voteBillJsonSnippit, $strpos + 2, $pos - 1);
		  echo '<article class="bill section group">

        <div class="billTitle">
            <h4>'.strtoupper($row["code"]).'</br>
            '.$row["title"].'</h4>
            <span>(Section 3 of 9)</span>
        </div>
    <div class="col span_1_of_3 first-child columnBottom">
        <p class="billDescription">'.$voteBillDescSnippit.'...</p>
        <p class="postNavigation">
            <span><a>PREVIOUS</a> | <a>NEXT</a></span>
        </p>
        <div class="postInfo">
            <span class="postAuthor">Submitted by <u>The Fourth Branch Team</u></span>
            <span class="timeStamp">11:30pm 01/07/2013</span>
        </div>';
		if(isset($_SESSION['voteUser'])) {
		echo '<script>
            $(function() {
                var $radios = $("input:radio[name=voteUser]");
                if($radios.is(":checked") === false) {
                    $radios.filter("[value='.$_SESSION['voteUser'].']").prop("checked", true);
                }
            });
        </script>';
        }
        echo '<div class="voteUserBox">
	        <form class="voteUser hasRadio" action="" method="POST">
	            <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange=';
	            if(isset($_SESSION)){
                	if(isset($_SESSION['voteUser'])) {
                    	echo 'preventDefault()';
                	} else {
                	echo 'this.form.submit()';
                	}
                } else {
                	echo 'a()';
                }
                echo '/>
	            <label for="pass">PASS<span></span></label>
	            <input type="radio" name="voteUser" class="voteReject" id="reject" value="reject" onChange=';
	            if(isset($_SESSION)){
	                if(isset($_SESSION['voteUser'])) {
	                    echo "preventDefault()";
	                } else {
	                echo "this.form.submit()";
	                }
	            } else {
	            	echo "a()";
	            }
	            echo '/>
	            <label for="reject">REJECT<span></span></label>
	        </form>
	    </div>
    </div>
    <div class="billDetails col span_2_of_3 columnBottom">
        <div class="billMapContainer clearblock">
            <h3>Statistics</h3>
            <div class="billMap">
                <img src="./images/map.png">
                <div class="passRejectSection">
                    <div class="passRejectBar">
                        <span>PASS</span><span class="right">REJECT</span>
                    </div>
                    <div class="percentages">
                        <span>50%</span><span class="right">50%</span>
                    </div>
                </div>
            </div>
            <ul class="billMapStatistics">
                <li>Consensus</li>
                <li>Female Opinion</li>
                <li>Male Opinion</li>
                <li>Under 18</li>
                <li>Age 18-65</li>
                <li>Age 65+</li>';
                echo "<select id='stateMap' name='stateMap'>
                    <option value=''>--Select State--</option><option value='Alabama'>AL</option>
                    <option value='Alaska'>AK</option><option value='Arizona'>AZ</option>
                    <option value='Arkansas'>AK</option><option value='California'>CA</option>
                    <option value='Colorado'>CO</option><option value='Connecticut'>CT</option>
                    <option value='Delaware'>DE</option><option value='Washington, D.C.'>DC</option>
                    <option value='Florida'>FL</option><option value='Georgia'>GA</option>
                    <option value='Hawaii'>HI</option><option value='Idaho'>ID</option>
                    <option value='Illinois'>IL</option><option value='Indiana'>IN</option>
                    <option value='Iowa'>IA</option><option value='Kansas'>KS</option>
                    <option value='Kentucky'>KY</option><option value='Louisiana'>LA</option>
                    <option value='Maine'>ME</option><option value='Maryland'>MD</option>
                    <option value='Massachusetts'>MA</option><option value='Michigan'>MI</option>
                    <option value='Minnesota'>MN</option><option value='Mississippi'>MS</option>
                    <option value='Missouri'>MO</option><option value='Montana'>MT</option>
                    <option value='Nebraska'>NE</option><option value='Nevada'>NV</option>
                    <option value='New Hampshire'>NH</option><option value='New Jersey'>NJ</option>
                    <option value='New Mexico'>NM</option><option value='New York'>NY</option>
                    <option value='North Carolina'>NC</option><option value='North Dakota'>ND</option>
                    <option value='Ohio'>OH</option><option value='Oklahoma'>OK</option>
                    <option value='Oregon'>OR</option><option value='Pennsylvania'>PA</option>
                    <option value='Rhode Island'>RI</option><option value='South Carolina'>SC</option>
                    <option value='South Dakota'>SD</option><option value='Tennessee'>TN</option>
                    <option value='Texas'>TX</option><option value='Utah'>UT</option>
                    <option value='Vermont'>VT</option><option value='Virginia'>VA</option>
                    <option value='Washington'>WA</option><option value='West Virginia'>WV</option>
                    <option value='Wisconsin'>WI</option><option value='Wyoming'>WY</option>
                </select>
            </ul>
        </div>";
        echo '<div class="share-buttons" style="padding-top:20px;">
            <button class="reddit shareButton">Reddit</button>
            <button class="google shareButton">Google</button>
            <button class="facebook shareButton">Facebook</button>
            <button class="linkedin shareButton">LinkedIn</button>
            <button class="twitter shareButton">Twitter</button>
            <button class="comment shareButton">Comment</button>
        </div>
    </div>
    </article>';
	}
    echo '</div>';
	echo '<div id="pages" style="margin-bottom:30px;">';
	if ($page != 0) {
		echo '<a style="color:black;" href="?page=' . ($index-1) . '">Previous Page</a> ';
	} if ($page + $limit < $count) { 
		echo '<a id="next" style="color:black;float:right;" href="?page=' . ($index+1) . '">Next Page</a>';
	}  echo "</div>";
	# Output the JS too
	echo "<script src='js/jquery.infinitescroll.min.js'></script>
	<script type='text/javascript'>
		$(document).ready(function() { 
			$('#results').infinitescroll({ 
				debug: true,
				navSelector : '#pages',
				nextSelector : '#next',
				itemSelector : '.bill',
			});
		});
	</script>";
 ?>