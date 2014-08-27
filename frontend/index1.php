<?php include("header1.php"); ?>
<div id="bodyWrap">
<?php
include("./inc/notd.php");
?>
<section class="billOfTheDay">
    <h1 class="seal">BILL OF THE DAY</h1>
    <article class="bill">
        <div class="billTitle">
            <h4>H.R. 4315:</br>
            21st Century Endangered Species Transparency Act</h4>
            <span>(Section 3 of 9)</span>
        </div>
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
        <form class="voteUser" action="" method="POST">
            <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange="this.form.submit()" />
            <label for="pass">PASS<span></span></label>
            <input type="radio" name="voteUser" class="voteReject" id="reject" value="reject" onChange=<?php 
            if(isset($_SESSION)){
                if(isset($_SESSION['voteUser'])) {
                    ?>"preventDefault()"<?php
                } else {
                ?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
            <label for="reject">REJECT<span></span></label>
        </form>
    </article>
    <article class="billDetails">
        <div class="share-buttons">
            <button class="reddit shareButton">Reddit</button>
            <button class="google shareButton">Google</button>
            <button class="facebook shareButton">Facebook</button>
            <button class="linkedin shareButton">LinkedIn</button>
            <button class="twitter shareButton">Twitter</button>
            <button class="comment shareButton">Comment</button>
        </div>
        <hr />
        <div class="billMapContainer clearblock">
            <h3>Statistics</h3>
            <div class="billMap">
                <img src="./images/map.png">
                <div class="passRejectSection">
                    <div class="passRejectBar">
                        <span>PASS</span><span>REJECT</span>
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
    </article>
    <article class="trendingComments">
        <h3>Trending Comments</h3>
        <div class="trendingCommentsBox">
            <span>I’m so Proud of my government. I think it’s really great to encourage such safety laws.I remember when people would just drink, drive, and speed without anyone doing anything. It’s about time the highways became safe. Did you know more people die from car accidents than from smoking??
            </span>
            <div class="trendingCommentsBoxUser">
                VOTER: Kyla20098
            </div>
        </div>
        <div class="trendingCommentsBox">
            <span>I’m so Proud of my government. I think it’s really great to encourage such safety laws.I remember when people would just drink, drive, and speed without anyone doing anything. It’s about time the highways became safe. Did you know more people die from car accidents than from smoking??
            </span>
            <div class="trendingCommentsBoxUser">
                VOTER: Kyla20098
            </div>
        </div>
        <div class="trendingCommentsBox">
            <span>I’m so Proud of my government. I think it’s really great to encourage such safety laws.I remember when people would just drink, drive, and speed without anyone doing anything. It’s about time the highways became safe. Did you know more people die from car accidents than from smoking??
            </span>
            <div class="trendingCommentsBoxUser">
                VOTER: Kyla20098
            </div>
        </div>
        <div class="addComment">
            <form action="" method="POST" class="addComment">
                <input type="textfield" placeholder="Enter your comment here...">
                <button type="submit" class="addCommentSubmit">
                SUBMIT
                </button>
            </form>
        </div>
    </article>
</section>
<section>
    <article class="tomorrowsBill">
        <h2>Tomorrow's Bill</h2>
        <div class="tomorrowsBillBox">
        <div class="tomorrowsBillTitle">
            <h4>H.R. 4315:</br>
            21st Century Endangered Species Transparency Act</h4>
        </div>
        <p>Amends MAP-21 to extend for the same period the authorization of appropriations for National Highway Safety Administration (NHTSA) safety programs, including: (1) highway safety research and development, (2) national priority safety programs, (3) the National Driver Register, (4) the High Visibility Enforcement Program, and (5) NHTSA administrative expenses. Amends SAFETEA-LU to extend for the same period high-visibility traffic safety law enforcement campaigns under the High Visibility Enforcement Program.</p>
        </div>
        <div class="tomorrowsBillParticipateBox">
            <div class="tomorrowsBillParticipateTitle">
                Participate
            </div>
            <p>Click here to submit a nonpartisan summary of tomorrow's bill of the day</p>
        </div>
    </article>
</section>
<?php include("footer1.php"); ?>