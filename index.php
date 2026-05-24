<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>INKREALM</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:#030712;

    font-family:'Poppins',sans-serif;

    color:white;

    overflow-x:hidden;
}

/* NAVBAR */

.navbar{

    width:100%;

    height:90px;

    background:#050816;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 70px;

    border-bottom:1px solid rgba(255,255,255,0.08);

    position:fixed;

    top:0;

    z-index:999;
}

.logo{

    display:flex;

    flex-direction:column;
}

.logo h1{

    color:#ff7b29;

    font-size:48px;

    font-weight:800;

    line-height:1;
}

.logo p{

    font-size:13px;

    color:#9ca3af;

    letter-spacing:2px;
}

.nav-links{

    display:flex;

    align-items:center;

    gap:40px;
}

.nav-links a{

    color:white;

    text-decoration:none;

    font-size:16px;

    transition:0.3s;
}

.nav-links a:hover{

    color:#ff7b29;
}

.auth-buttons{

    display:flex;

    gap:15px;
}

.btn{

    padding:14px 30px;

    border-radius:12px;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;
}

.login-btn{

    border:2px solid #ff7b29;

    color:#ff7b29;
}

.login-btn:hover{

    background:#ff7b29;

    color:white;
}

.register-btn{

    background:#ff7b29;

    color:white;
}

.register-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 0 20px rgba(255,123,41,0.5);
}

/* HERO */

.hero{

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:160px 80px 100px;

    background:
    linear-gradient(
    rgba(0,0,0,0.75),
    rgba(0,0,0,0.85)
    ),

   

    background-size:cover;

    background-position:center;
}

.hero-left{

    width:50%;
}

.hero-left h2{

    font-size:82px;

    line-height:1.1;

    margin-bottom:25px;

    font-weight:800;
}

.orange{

    color:#ff7b29;
}

.hero-line{

    width:260px;

    height:4px;

    background:#ff7b29;

    margin-bottom:35px;

    border-radius:20px;
}

.hero-left p{

    font-size:22px;

    line-height:1.8;

    color:#d1d5db;

    margin-bottom:45px;

    max-width:700px;
}

.hero-buttons{

    display:flex;

    gap:25px;
}

.hero-btn{

    padding:18px 40px;

    border-radius:15px;

    text-decoration:none;

    font-size:18px;

    font-weight:600;

    transition:0.3s;
}

.start-btn{

    background:#ff7b29;

    color:white;
}

.start-btn:hover{

    transform:translateY(-4px);

    box-shadow:0 0 30px rgba(255,123,41,0.4);
}

.read-btn{

    border:2px solid #ff7b29;

    color:#ff7b29;
}

.read-btn:hover{

    background:#ff7b29;

    color:white;
}

.hero-right{

    width:45%;

    display:flex;

    justify-content:center;
}

.hero-right img{

    width:100%;

    max-width:650px;

    border-radius:30px;

    box-shadow:0 0 40px rgba(255,123,41,0.2);
}

/* STATS */

.stats{

    width:90%;

    margin:auto;

    margin-top:-70px;

    background:#111827;

    border-radius:30px;

    padding:40px;

    display:grid;

    grid-template-columns:
    repeat(4,1fr);

    gap:30px;

    position:relative;

    z-index:10;

    border:1px solid rgba(255,255,255,0.08);
}

.stat-box{

    text-align:center;
}

.stat-box h3{

    font-size:42px;

    color:#ff7b29;

    margin-bottom:10px;
}

.stat-box p{

    color:#d1d5db;

    font-size:18px;
}

/* FEATURES */

.features{

    padding:120px 80px;
}

.section-title{

    text-align:center;

    font-size:52px;

    margin-bottom:70px;

    color:#ff7b29;
}

.feature-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(260px,1fr));

    gap:35px;
}

.feature-card{

    background:#111827;

    padding:40px;

    border-radius:25px;

    transition:0.3s;

    border:1px solid rgba(255,255,255,0.05);
}

.feature-card:hover{

    transform:translateY(-8px);

    box-shadow:0 0 25px rgba(255,123,41,0.2);
}

.feature-card h3{

    color:#ff7b29;

    margin-bottom:20px;

    font-size:28px;
}

.feature-card p{

    color:#d1d5db;

    line-height:1.8;

    font-size:17px;
}

/* FOOTER */

.footer{

    background:#050816;

    text-align:center;

    padding:35px;

    color:#9ca3af;

    border-top:1px solid rgba(255,255,255,0.08);
}

/* MOBILE */

@media(max-width:1100px){

.hero{

    flex-direction:column;

    text-align:center;

    padding-top:180px;
}

.hero-left,
.hero-right{

    width:100%;
}

.hero-left{

    margin-bottom:60px;
}

.hero-buttons{

    justify-content:center;
}

.hero-line{

    margin:auto;

    margin-bottom:35px;
}

.stats{

    grid-template-columns:
    repeat(2,1fr);
}
}

@media(max-width:700px){

.navbar{

    padding:0 20px;
}

.nav-links{

    display:none;
}

.hero-left h2{

    font-size:54px;
}

.hero-left p{

    font-size:18px;
}

.hero-buttons{

    flex-direction:column;
}

.stats{

    grid-template-columns:1fr;
}

.section-title{

    font-size:38px;
}
}

</style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

<div class="logo">

<h1>
INKREALM
</h1>

<p>
WRITE. READ. INSPIRE.
</p>

</div>

<div class="nav-links">

<a href="#">
Home
</a>

<a href="stories.php">
Stories
</a>

<a href="author.php">
Authors
</a>

<a href="top_gifts.php">
Rankings
</a>

<a href="#">
Explore
</a>

<a href="#">
Premium
</a>

</div>

<div class="auth-buttons">

<a href="login.php"
class="btn login-btn">

Login

</a>

<a href="register.php"
class="btn register-btn">

Register

</a>

</div>

</div>

<!-- HERO -->

<section class="hero">

<div class="hero-left">

<h2>

Step Into a World
of

<span class="orange">

Endless Stories

</span>

</h2>

<div class="hero-line"></div>

<p>

INKREALM is a premium platform
where writers share imagination
and readers discover addictive
stories that stay with them forever.

</p>

<div class="hero-buttons">

<a href="upload.php"
class="hero-btn start-btn">

✍️ Start Writing

</a>

<a href="stories.php"
class="hero-btn read-btn">

📚 Start Reading

</a>

</div>

</div>

<div class="hero-right">

<img src='617729a2-497d-4b9a-a76c-0525be525b26.png'>

</div>

</section>

<!-- STATS -->

<div class="stats">

<div class="stat-box">

<h3>
100K+
</h3>

<p>
Stories
</p>

</div>

<div class="stat-box">

<h3>
50K+
</h3>

<p>
Writers
</p>

</div>

<div class="stat-box">

<h3>
1M+
</h3>

<p>
Readers
</p>

</div>

<div class="stat-box">

<h3>
#1
</h3>

<p>
Top Rankings
</p>

</div>

</div>

<!-- FEATURES -->

<section class="features">

<h2 class="section-title">

Why Readers Love INKREALM

</h2>

<div class="feature-grid">

<div class="feature-card">

<h3>
📚 Premium Stories
</h3>

<p>

Discover romance, werewolf,
CEO, fantasy, mafia,
dark romance, and more.

</p>

</div>

<div class="feature-card">

<h3>
💎 Unlock Chapters
</h3>

<p>

Use coins to unlock premium
chapters and binge addictive
stories.

</p>

</div>

<div class="feature-card">

<h3>
🎁 Gift Authors
</h3>

<p>

Support your favorite writers
through gifts and rankings.

</p>

</div>

<div class="feature-card">

<h3>
🏆 Trending Rankings
</h3>

<p>

Explore the hottest stories
rising across the platform.

</p>

</div>

</div>

</section>

<!-- FOOTER -->

<div class="footer">

© 2026 INKREALM — All Rights Reserved

</div>

</body>

</html>
