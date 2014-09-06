<?php include("header.php"); ?>
<div class="bodyWrap">
	<section class="votePage">
		<h1 class="seal">Vote</h1>
		<article class="voteSearch">
			<div class="searchBox">
				<h3>Search for Bills</h3>
				<form method="POST" action="" name="billSearch" id="billSearch">
				<div class="searchKeywords">
					<input type="search" name="keyword" size="40" placeholder="Enter Keywords..." autofocus>
					<button class="button" type="submit" name="search-button">Search</button>
					</div><div class="searchSortBy">
						<h4>Sort By</h4>
						<label for="mostAgreed" class="sortBy button">Most Agreed</label>
						<input type="radio" class="button" name="sortBy" id="mostAgreed" value="mostAgreed">
						<label for="mostDisagreed" class="sortBy button">Most Disagreed</label>
						<input type="radio" class="button" name="sortBy" id="mostDisagreed" value="mostDisagreed">
						<label for="popularity" class="sortBy button">Popularity</label>
						<input type="radio" class="button" name="sortBy" id="popularity" value="popularity">
						<label for="mostAgreed" class="sortBy button">Most Agreed</label>
						<input type="radio" class="button" name="sortBy" id="mostAgreed" value="mostAgreed">

					</div>
				</form>
			</div>
		</article>
	    <article class="bill section group">
	        <div class="billTitle">
	            <h4>H.R. 4315:</br>
	            21st Century Endangered Species Transparency Act</h4>
	            <span>(Section 3 of 9)</span>
	        </div>
	    <div class="col span_1_of_3 first-child columnBottom">
	        <p class="billDescription">Amends MAP-21 to extend for the same period the authorization of appropriations for National Highway Safety Administration (NHTSA) safety programs, including: (1) highway safety research and development, (2) national priority safety programs, (3) the National Driver Register, (4) the High Visibility Enforcement Program, and (5) NHTSA administrative expenses.

	        Amends SAFETEA-LU to extend for the same period high-visibility traffic safety law enforcement campaigns under the High Visibility Enforcement Program.</p>
	        <p class="postNavigation">
	            <span><a>PREVIOUS</a> | <a>NEXT</a></span>
	        </p>
	        <div class="postInfo">
	            <span class="postAuthor">Submitted by <u>The Fourth Branch Team</u></span>
	            <span class="timeStamp">11:30pm 01/07/2013</span>
	        </div>

	        <?php if(isset($_SESSION['voteUser'])) {?>
	        <script>
	            $(function() {
	                var $radios = $('input:radio[name=voteUser]');
	                if($radios.is(':checked') === false) {
	                    $radios.filter('[value=<?php echo $_SESSION['voteUser']; ?>]').prop('checked', true);
	                }
	            });
	        </script>
	        <?php } ?>
	        <div class="voteUserBox">
		        <form class="voteUser" action="" method="POST">
		            <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange=
		            <?php if(isset($_SESSION)){
	                	if(isset($_SESSION['voteUser'])) {
	                    	?>"preventDefault()"<?php
	                	} else {
	                	?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
		            <label for="pass">PASS<span></span></label>
		            <input type="radio" name="voteUser" class="voteReject" id="reject" value="reject" onChange=<?php 
		            if(isset($_SESSION)){
		                if(isset($_SESSION['voteUser'])) {
		                    ?>"preventDefault()"<?php
		                } else {
		                ?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
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
	                <li>Age 65+</li>
	                <select id='stateMap' name="stateMap">
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
	        </div>
	        <div class="share-buttons" style="padding-top:20px;">
	            <button class="reddit shareButton">Reddit</button>
	            <button class="google shareButton">Google</button>
	            <button class="facebook shareButton">Facebook</button>
	            <button class="linkedin shareButton">LinkedIn</button>
	            <button class="twitter shareButton">Twitter</button>
	            <button class="comment shareButton">Comment</button>
	        </div>
	    </div>
	    </article>
	    <article class="bill section group">
	        <div class="billTitle">
	            <h4>H.R. 4315:</br>
	            21st Century Endangered Species Transparency Act</h4>
	            <span>(Section 3 of 9)</span>
	        </div>
	    <div class="col span_1_of_3 first-child columnBottom">
	        <p class="billDescription">Amends MAP-21 to extend for the same period the authorization of appropriations for National Highway Safety Administration (NHTSA) safety programs, including: (1) highway safety research and development, (2) national priority safety programs, (3) the National Driver Register, (4) the High Visibility Enforcement Program, and (5) NHTSA administrative expenses.

	        Amends SAFETEA-LU to extend for the same period high-visibility traffic safety law enforcement campaigns under the High Visibility Enforcement Program.</p>
	        <p class="postNavigation">
	            <span><a>PREVIOUS</a> | <a>NEXT</a></span>
	        </p>
	        <div class="postInfo">
	            <span class="postAuthor">Submitted by <u>The Fourth Branch Team</u></span>
	            <span class="timeStamp">11:30pm 01/07/2013</span>
	        </div>

	        <?php if(isset($_SESSION['voteUser'])) {?>
	        <script>
	            $(function() {
	                var $radios = $('input:radio[name=voteUser]');
	                if($radios.is(':checked') === false) {
	                    $radios.filter('[value=<?php echo $_SESSION['voteUser']; ?>]').prop('checked', true);
	                }
	            });
	        </script>
	        <?php } ?>
	        <div class="voteUserBox">
		        <form class="voteUser" action="" method="POST">
		            <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange=
		            <?php if(isset($_SESSION)){
	                	if(isset($_SESSION['voteUser'])) {
	                    	?>"preventDefault()"<?php
	                	} else {
	                	?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
		            <label for="pass">PASS<span></span></label>
		            <input type="radio" name="voteUser" class="voteReject" id="reject" value="reject" onChange=<?php 
		            if(isset($_SESSION)){
		                if(isset($_SESSION['voteUser'])) {
		                    ?>"preventDefault()"<?php
		                } else {
		                ?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
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
	                <li>Age 65+</li>
	                <select id='stateMap' name="stateMap">
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
	        </div>
	        <div class="share-buttons" style="padding-top:20px;">
	            <button class="reddit shareButton">Reddit</button>
	            <button class="google shareButton">Google</button>
	            <button class="facebook shareButton">Facebook</button>
	            <button class="linkedin shareButton">LinkedIn</button>
	            <button class="twitter shareButton">Twitter</button>
	            <button class="comment shareButton">Comment</button>
	        </div>
	    </div>
	    </article>

    </section>
</div>
<?php include("footer.php"); ?>