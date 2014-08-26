<?php include("header1.php");
include("./inc/notd.php");
?>
<section class="billOfTheDay">
    <header class="seal">BILL OF THE DAY</header>
    <article class="bill">
        <div class="billTitle">
            <h4>H.R. 4315:</br>
            21st Century Endangered Species Transparency Act</h4>
            <span>Section 3 of 9</span>
        </div>
        <p>Amends the Endangered Species Act of 1973 to require the Secretary of the Interior or the Secretary of Commerce, as appropriate, to make publicly available on the Internet the best scientific and commercial data available that are the basis for the determination of whether a species is an endangered species or a threatened species, including each proposed regulation for the listing of a species.</p>
        <span class="postNavigation">
            PREVIOUS | NEXT
        </span>
        <div class="postInfo">
            <span class="postAuthor">Submitted by <u>The Fourth Branch Team</u></span>
            <span class="timeStamp">11:30pm 01/07/2013</span>
        </div>
        <form class="voteUser" action="" method="POST">
            <label for="votePass">PASS</label>
            <input type="checkbox" name="voteUser[]" value="pass" onChange="this.form.submit()" />
            <label for="votePass">REJECT</label>
            <input type="checkbox" name="voteUser[]" value="reject" onChange="this.form.submit()" />
        </form>
        <div class="share-buttons">
            <button class="reddit shareButton">Reddit</button>
            <button class="google shareButton">Google</button>
            <button class="facebook shareButton">Facebook</button>
            <button class="linkedin shareButton">LinkedIn</button>
            <button class="twitter shareButton">Twitter</button>
            <button class="comment shareButton">Comment</button>
        </div>
    </article>
    <article class="billMapContainer">
        <h3>Statistics</h3>
        <div class="billMap">
            <img src="./images/billMap.png">
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
            <li>--Select State--</li>
        </ul>
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