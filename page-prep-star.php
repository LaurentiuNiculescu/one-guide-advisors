<?php
/*
*/

$web3FormsKey = "{your api here}"; 

?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Prep | The STAR Method</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a8a; /* Oxford Blue */
            --secondary: #b45309; /* Academic Gold */
            --panel-bg: rgba(255, 255, 255, 0.98);
            --text-main: #1f2937;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --correct: #dcfce7;
            --wrong: #fee2e2;
            --transition: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
        
        body { 
            background-image: linear-gradient(rgba(253, 251, 247, 0.9), rgba(253, 251, 247, 0.95)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-attachment: fixed;
            color: var(--text-main); font-family: 'Lato', sans-serif;
            display: flex; flex-direction: column; min-height: 100vh; line-height: 1.6;
        }

        h1, h2, h3, h4, .brand-text { font-family: 'Playfair Display', serif; }

        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .hidden { display: none; }
        .fade-in { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .btn { padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-weight: 700; transition: var(--transition); display: inline-block; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; }
        .btn-primary { background-color: var(--primary); color: white; border: 1px solid var(--primary); }
        .btn-primary:hover { background-color: #172554; transform: translateY(-2px); box-shadow: var(--shadow-card); }
        .btn-outline { background: transparent; border: 1px solid var(--primary); color: var(--primary); display: flex; align-items: center; gap: 8px; }
        .btn-outline:hover { background: var(--primary); color: white; }

        nav { background: var(--panel-bg); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(10px); }
        nav .container { display: flex; justify-content: space-between; align-items: center; height: 90px; }
        
        .brand-col { display: flex; flex-direction: column; align-items: center; text-decoration: none; }
        .brand-logo { height: 45px; width: auto; margin-bottom: 2px; }
        .brand-text { font-size: 1rem; font-weight: 700; color: var(--primary); letter-spacing: 0.5px; }

        .desktop-menu { display: flex; align-items: center; gap: 25px; }
        .nav-link { text-decoration: none; color: var(--text-main); font-weight: 600; font-size: 0.9rem; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; }
        .nav-link:hover { color: var(--secondary); }

        .mobile-toggle { display: none; font-size: 1.5rem; color: var(--primary); cursor: pointer; background: none; border: none; }
        #mobile-menu { display: none; position: absolute; top: 90px; left: 0; width: 100%; background: white; border-bottom: 4px solid var(--secondary); padding: 20px; flex-direction: column; gap: 15px; box-shadow: var(--shadow-card); }
        #mobile-menu.active { display: flex; }
        .mobile-link { color: var(--text-main); text-decoration: none; font-weight: 700; font-size: 1.1rem; text-align: center; padding: 10px; border-bottom: 1px solid #eee; }

        .lang-container { position: relative; display: inline-block; }
        .lang-btn { background: white; border: 1px solid #cbd5e1; color: var(--text-main); padding: 8px 15px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .lang-btn:hover { border-color: var(--primary); color: var(--primary); }
        .lang-dropdown { display: none; position: absolute; right: 0; top: 45px; background: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 160px; z-index: 1001; overflow: hidden; animation: slideDown 0.3s ease forwards; border: 1px solid var(--border-color); }
        .lang-dropdown.active { display: block; }
        .lang-option { padding: 10px 15px; cursor: pointer; color: #333; font-size: 0.9rem; border-bottom: 1px solid #f0f0f0; transition: 0.2s; }
        .lang-option:hover { background: #f1f5f9; color: var(--primary); padding-left: 20px; }
        .mobile-lang-select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9; color: #333; margin-top: 10px; font-size: 1rem; }
        
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .hero { text-align: center; padding: 80px 0 60px; border-bottom: 1px solid var(--border-color); }
        .hero h1 { font-size: 3rem; margin-bottom: 15px; color: var(--primary); }
        .hero p { font-size: 1.2rem; color: var(--text-muted); max-width: 700px; margin: 0 auto; }

        .card { background: var(--panel-bg); border: 1px solid var(--border-color); padding: 40px; border-radius: 8px; margin-bottom: 40px; box-shadow: var(--shadow-card); position: relative; }
        
        .star-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
        .star-item { background: #fff; padding: 25px; border-radius: 6px; border: 1px solid var(--border-color); border-top: 4px solid var(--primary); transition: 0.3s; }
        .star-item:hover { transform: translateY(-5px); border-top-color: var(--secondary); box-shadow: var(--shadow-card); }
        .star-letter { font-size: 3rem; font-weight: 700; color: var(--secondary); font-family: 'Playfair Display', serif; display: block; margin-bottom: 10px; }
        
        .example-box { background: #f8fafc; padding: 25px; border-radius: 6px; border: 1px solid var(--border-color); margin-top: 20px; }
        .bad-answer { border-left: 4px solid #ef4444; padding: 15px; margin-bottom: 20px; background: #fef2f2; border-radius: 0 4px 4px 0; }
        .good-answer { border-left: 4px solid #22c55e; padding: 15px; background: #f0fdf4; border-radius: 0 4px 4px 0; }

        .quiz-question { margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .quiz-question h4 { margin-bottom: 15px; color: var(--text-main); font-family: 'Lato', sans-serif; font-weight: 700; }
        .quiz-options { list-style: none; }
        .quiz-option { 
            padding: 15px; margin-bottom: 10px; background: white; border: 1px solid #cbd5e1; 
            border-radius: 4px; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 10px;
        }
        .quiz-option:hover { background: #eff6ff; border-color: var(--primary); }
        .quiz-option.correct { background-color: var(--correct); border-color: #22c55e; color: #14532d; }
        .quiz-option.wrong { background-color: var(--wrong); border-color: #ef4444; color: #7f1d1d; }
        
        .score-board { text-align: center; font-size: 1.5rem; font-weight: bold; color: var(--primary); margin-top: 20px; display: none; padding: 20px; background: #f0f9ff; border-radius: 8px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; color: white; font-size: 0.9rem; margin-bottom: 8px; font-weight: 700; }
        .form-input { width: 100%; padding: 14px; background: rgba(255,255,255,0.9); border: 1px solid transparent; border-radius: 4px; font-size: 1rem; transition: 0.3s; font-family: 'Lato', sans-serif; }
        .form-input:focus { outline: none; border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(180, 83, 9, 0.3); }

        footer { background: #1e3a8a; color: white; padding: 40px 0; margin-top: auto; text-align: center; border-top: 4px solid var(--secondary); }
        footer a { color: var(--secondary); text-decoration: none; font-weight: bold; }
        footer a:hover { color: white; text-decoration: underline; }

        @media(max-width: 900px) {
            .desktop-menu { display: none; }
            .mobile-toggle { display: block; }
            .hero { padding: 50px 0; }
            .hero h1 { font-size: 2rem; }
            .card { padding: 25px; }
            .form-grid { grid-template-columns: 1fr; gap: 15px; }
        }
    </style>
</head>
<body>

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-28 flex justify-between items-center relative">
            
            <a href="index.php" class="flex flex-col items-center justify-center gap-0 group no-underline">
                <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-10 w-auto object-contain mb-1 transition group-hover:scale-105">
                
                <span class="brand-text text-sm font-bold text-blue-900 leading-tight">One Guide</span>
                <span class="text-sm font-medium text-gray-700">
        We help you find the right direction
    </span>

                <span class="text-[9px] font-bold text-blue-900 tracking-wide uppercase mt-0.5">
                    Powered by <span class="hover:text-red-600 active:text-red-700 transition-colors cursor-pointer" 
onclick="window.open('https://www.ask33.co.uk/', '_blank')">ASK 33</span>
                </span>
            </a>

            
            <div style="display:flex; align-items:center; gap:20px;">
                <div class="lang-container">
                    <div class="lang-btn" onclick="toggleLangMenu()">
                        <i class="fa-solid fa-globe"></i> <span id="current-lang">English</span> <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="lang-dropdown" id="lang-dropdown">
                        <div class="lang-option" onclick="setLang('en')">🇬🇧 English</div>
                        <div class="lang-option" onclick="setLang('ro')">🇷🇴 Română</div>
                        <div class="lang-option" onclick="setLang('pl')">🇵🇱 Polski</div>
                        <div class="lang-option" onclick="setLang('hu')">🇭🇺 Magyar</div>
                        <div class="lang-option" onclick="setLang('es')">🇪🇸 Español</div>
                        <div class="lang-option" onclick="setLang('it')">🇮🇹 Italiano</div>
                        <div class="lang-option" onclick="setLang('pt')">🇵🇹 Português</div>
                        <div class="lang-option" onclick="setLang('el')">🇬🇷 Ελληνικά</div>
                        <div class="lang-option" onclick="setLang('bg')">🇧🇬 Български</div>
                    </div>
                </div>

                <a href="<?php echo home_url(); ?>" class="btn btn-outline" style="padding: 8px 20px; border-radius: 4px;">
                    <i class="fa-solid fa-arrow-left"></i> <span data-key="nav_back">Back Home</span>
                </a>
            </div>
        </div>
    </nav>

    <header class="hero fade-in">
        <div class="container">
            <h1 data-key="hero_title">Mastering the STAR Method</h1>
            <p data-key="hero_desc">The definitive guide to structuring your answers for behavioral interviews at UK universities and job applications.</p>
        </div>
    </header>

    <main class="container fade-in" style="animation-delay: 0.2s;">
        
        <div class="card" style="margin-top: -40px;">
            <h2 data-key="intro_title">What is the STAR Method?</h2>
            <p style="color:var(--text-muted);" data-key="intro_text">Admissions officers often ask <strong>Competency-Based Questions</strong>. The STAR method is a structured technique to answer these questions concisely.</p>
            
            <div class="star-grid">
                <div class="star-item">
                    <span class="star-letter">S</span>
                    <h3 data-key="star_s">Situation</h3>
                    <p style="font-size:0.9rem; color:var(--text-muted);" data-key="desc_s">Set the scene. Briefly describe the context, background, or specific problem you faced. Keep this short (10%).</p>
                </div>
                <div class="star-item">
                    <span class="star-letter">T</span>
                    <h3 data-key="star_t">Task</h3>
                    <p style="font-size:0.9rem; color:var(--text-muted);" data-key="desc_t">Explain your responsibility. What was the goal? What were you trying to achieve? (10%).</p>
                </div>
                <div class="star-item">
                    <span class="star-letter">A</span>
                    <h3 data-key="star_a">Action</h3>
                    <p style="font-size:0.9rem; color:var(--text-muted);" data-key="desc_a"><strong>The most important part.</strong> Describe what YOU specifically did. Use "I" statements, not "We". (60%).</p>
                </div>
                <div class="star-item">
                    <span class="star-letter">R</span>
                    <h3 data-key="star_r">Result</h3>
                    <p style="font-size:0.9rem; color:var(--text-muted);" data-key="desc_r">Share the outcome. Quantify it if possible (numbers/grades) and reflect on what you learned. (20%).</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 data-key="ex_title">Real World Example</h2>
            <p style="margin-bottom:20px;"><strong data-key="ex_q_label">Question:</strong> <span data-key="ex_q_text">"Describe a time you had to manage a heavy workload."</span></p>

            <div class="example-box">
                <div class="bad-answer">
                    <strong data-key="bad_lbl">❌ Weak Answer:</strong><br>
                    <span data-key="bad_txt">"I had a lot of exams and I was working part-time. It was really hard but I just worked harder and got it done." (Too vague).</span>
                </div>

                <div class="good-answer">
                    <strong data-key="good_lbl">✅ STAR Answer:</strong><br>
                    <span data-key="good_txt"><strong>(Situation)</strong> During my final year, I had three deadlines. <strong>(Task)</strong> I needed to maintain grades while managing a team. <strong>(Action)</strong> I created a detailed timetable and used the Pomodoro technique. <strong>(Result)</strong> I achieved Distinction grades and met all targets.</span>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="text-align: center; margin-bottom: 30px;"><i class="fa-solid fa-graduation-cap"></i> <span data-key="quiz_title">Test Your Knowledge</span></h2>
            
            <div id="quiz-container">
                <div class="quiz-question">
                    <h4 data-key="q1">1. Which part of the STAR answer should be the longest?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q1_a">A) Situation</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q1_b">B) Result</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q1_c">C) Action</span></li>
                    </ul>
                </div>

                <div class="quiz-question">
                    <h4 data-key="q2">2. In the 'Action' section, which word should you use most?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q2_a">A) "We"</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q2_b">B) "I"</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q2_c">C) "They"</span></li>
                    </ul>
                </div>

                <div class="quiz-question">
                    <h4 data-key="q3">3. What should you include in the 'Result'?</h4>
                    <ul class="quiz-options">
                        <li class="quiz-option" onclick="checkAnswer(this, false)"><span data-key="q3_a">A) Just say "it went well".</span></li>
                        <li class="quiz-option" onclick="checkAnswer(this, true)"><span data-key="q3_b">B) Concrete outcomes and what you learned.</span></li>
                    </ul>
                </div>
            </div>

            <div id="score-board" class="score-board"></div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p style="color:var(--text-muted); margin-bottom:15px;" data-key="cta_text">Need to practice with a real person?</p>
                <a href="#contact" class="btn btn-primary" data-key="cta_btn">Book a Mock Interview</a>
            </div>
        </div>

        <div class="card" id="contact" style="background: var(--primary); color: white; border: none;">
            <h2 style="text-align:center; margin-bottom:20px; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom:15px;">
                <i class="fa-solid fa-envelope"></i> <span data-key="form_header">Need help with Prep?</span>
            </h2>
            <p style="text-align:center; margin-bottom:30px; opacity:0.9;" data-key="form_sub">Contact us for personalized coaching.</p>
            
            <form action="https://api.web3forms.com/submit" method="POST">
                
                <input type="hidden" name="access_key" value="<?php echo $web3FormsKey; ?>">
                
                <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                <input type="hidden" name="subject" value="New Prep Inquiry (STAR Method)">
                <input type="hidden" name="from_name" value="One Guide Prep">

                <div class="form-grid">
                    <div class="form-group"><label class="form-label" data-key="lbl_name">Full Name</label><input type="text" name="name" class="form-input" required></div>
                    <div class="form-group"><label class="form-label" data-key="lbl_phone">Phone Number</label><input type="tel" name="phone" class="form-input" required></div>
                </div>
                <div class="form-group"><label class="form-label" data-key="lbl_email">Email Address</label><input type="email" name="email" class="form-input" required></div>
                <div class="form-group"><label class="form-label" data-key="lbl_msg">Questions / Goals</label><textarea name="message" rows="4" class="form-input" required></textarea></div>
                
                <button type="submit" class="btn" style="width: 100%; background: var(--secondary); color: white;" data-key="btn_send">Send Request</button>
            </form>
        </div>

    </main>

 <footer class="bg-gray-100 text-gray-500 py-12 text-center mt-12 border-t border-gray-200">
        <div class="flex flex-col items-center justify-center mb-6">
             <img src="<?php echo get_template_directory_uri(); ?>/images/One-Guide.png" alt="Logo" class="h-16 w-auto opacity-90 object-contain">
             <span class="brand-text text-gray-800 mt-2 text-xl font-bold">One Guide</span>
             <a href="https://www.ask33.co.uk/" target="_blank" class="text-[10px] text-gray-400 font-bold hover:text-red-600 transition mt-1 uppercase">Powered by ASK 33</a>
        </div>
        <p class="text-sm">Site by <a href="https://www.alphaitsolutions.uk" target="_blank" class="text-blue-500 hover:text-red-700 font-bold transition">Alpha IT Solutions</a></p>
        <p class="text-xs mt-2 opacity-50">&copy; 2026 One Guide Advisors.</p>
    </footer>

    <script>
        const translations = {
            en: {
                nav_back: "Back Home", hero_title: "Mastering the STAR Method", hero_desc: "The definitive guide to structuring your answers for behavioral interviews.",
                intro_title: "What is the STAR Method?", intro_text: "Admissions officers often ask Competency-Based Questions. The STAR method is a structured technique to answer these questions concisely.",
                star_s: "Situation", desc_s: "Set the scene. Briefly describe the context, background, or specific problem you faced.",
                star_t: "Task", desc_t: "Explain your responsibility. What was the goal? What were you trying to achieve?",
                star_a: "Action", desc_a: "The most important part. Describe what YOU specifically did. Use 'I' statements.",
                star_r: "Result", desc_r: "Share the outcome. Quantify it if possible and reflect on what you learned.",
                ex_title: "Real World Example", ex_q_label: "Question:", ex_q_text: "\"Describe a time you had to manage a heavy workload.\"",
                bad_lbl: "❌ Weak Answer:", bad_txt: "\"I had a lot of exams and I was working part-time. It was really hard but I just worked harder.\"",
                good_lbl: "✅ STAR Answer:", good_txt: "(Situation) During my final year, I had three deadlines. (Task) I needed to maintain grades while managing a team. (Action) I created a detailed timetable. (Result) I achieved Distinction grades.",
                quiz_title: "Test Your Knowledge",
                q1: "1. Which part of the STAR answer should be the longest?", q1_a: "A) Situation", q1_b: "B) Result", q1_c: "C) Action",
                q2: "2. In the 'Action' section, which word should you use?", q2_a: "A) \"We\"", q2_b: "B) \"I\"", q2_c: "C) \"They\"",
                q3: "3. What should you include in the 'Result'?", q3_a: "A) Just say 'it went well'.", q3_b: "B) Concrete outcomes.",
                cta_text: "Need to practice with a real person?", cta_btn: "Book a Mock Interview",
                form_header: "Need help with Prep?", form_sub: "Contact us for personalized interview coaching.",
                lbl_name: "Full Name", lbl_phone: "Phone Number", lbl_email: "Email Address", lbl_msg: "Questions / Goals", btn_send: "Send Request"
            },
            ro: {
                nav_back: "Înapoi Acasă", hero_title: "Stăpânirea Metodei STAR", hero_desc: "Ghidul definitiv pentru structurarea răspunsurilor la interviurile comportamentale.",
                intro_title: "Ce este Metoda STAR?", intro_text: "Ofițerii de admitere pun adesea întrebări bazate pe competențe. Metoda STAR este o tehnică structurată.",
                star_s: "Situație", desc_s: "Descrie contextul sau problema specifică pe scurt.",
                star_t: "Sarcină", desc_t: "Care a fost obiectivul? Ce ai încercat să realizezi?",
                star_a: "Acțiune", desc_a: "Cea mai importantă parte. Descrie ce ai făcut TU specific. Folosește 'Eu'.",
                star_r: "Rezultat", desc_r: "Împărtășește rezultatul. Cuantifică dacă este posibil.",
                ex_title: "Exemplu Real", ex_q_label: "Întrebare:", ex_q_text: "\"Descrie un moment când ai gestionat un volum mare de muncă.\"",
                bad_lbl: "❌ Răspuns Slab:", bad_txt: "\"Am avut multe examene și lucram. A fost greu dar am muncit mai mult.\"",
                good_lbl: "✅ Răspuns STAR:", good_txt: "(Situație) În ultimul an, am avut trei termene limită. (Sarcină) Trebuia să mențin notele. (Acțiune) Am creat un orar detaliat. (Rezultat) Am obținut note de Distincție.",
                quiz_title: "Testează-ți Cunoștințele",
                q1: "1. Care parte a răspunsului STAR ar trebui să fie cea mai lungă?", q1_a: "A) Situația", q1_b: "B) Rezultatul", q1_c: "C) Acțiunea",
                q2: "2. În secțiunea 'Acțiune', ce cuvânt ar trebui să folosești?", q2_a: "A) \"Noi\"", q2_b: "B) \"Eu\"", q2_c: "C) \"Ei\"",
                q3: "3. Ce ar trebui să incluzi în 'Rezultat'?", q3_a: "A) Doar spune 'a mers bine'.", q3_b: "B) Rezultate concrete.",
                cta_text: "Vrei să exersezi cu o persoană reală?", cta_btn: "Rezervă un Interviu Simulat",
                form_header: "Ai nevoie de ajutor?", form_sub: "Contactează-ne pentru pregătire personalizată.",
                lbl_name: "Nume Complet", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Întrebări / Scopuri", btn_send: "Trimite Cerere"
            },
            pl: {
                nav_back: "Powrót", hero_title: "Metoda STAR", hero_desc: "Przewodnik po strukturyzowaniu odpowiedzi na rozmowach kwalifikacyjnych.",
                intro_title: "Czym jest metoda STAR?", intro_text: "Technika strukturyzowania odpowiedzi na pytania behawioralne.",
                star_s: "Sytuacja", desc_s: "Opisz krótko kontekst lub problem.",
                star_t: "Zadanie", desc_t: "Jaki był cel? Co chciałeś osiągnąć?",
                star_a: "Akcja", desc_a: "Najważniejsza część. Opisz, co TY zrobiłeś.",
                star_r: "Rezultat", desc_r: "Podziel się wynikiem. Użyj liczb, jeśli to możliwe.",
                ex_title: "Przykład", ex_q_label: "Pytanie:", ex_q_text: "\"Opisz sytuację, gdy miałeś dużo pracy.\"",
                bad_lbl: "❌ Słaba odp:", bad_txt: "\"Miałem dużo egzaminów. Było ciężko, ale dałem radę.\"",
                good_lbl: "✅ Odp STAR:", good_txt: "(Sytuacja) Miałem 3 terminy. (Zadanie) Musiałem utrzymać oceny. (Akcja) Stworzyłem harmonogram. (Rezultat) Zdałem z wyróżnieniem.",
                quiz_title: "Sprawdź Wiedzę",
                q1: "1. Która część powinna być najdłuższa?", q1_a: "A) Sytuacja", q1_b: "B) Rezultat", q1_c: "C) Akcja",
                q2: "2. Jakiego słowa używać w 'Akcji'?", q2_a: "A) \"My\"", q2_b: "B) \"Ja\"", q2_c: "C) \"Oni\"",
                q3: "3. Co zawrzeć w 'Rezultacie'?", q3_a: "A) \"Poszło dobrze\"", q3_b: "B) Konkretne wyniki",
                cta_text: "Chcesz poćwiczyć?", cta_btn: "Umów Próbną Rozmowę",
                form_header: "Pomoc w nauce?", form_sub: "Skontaktuj się z nami.",
                lbl_name: "Imię i Nazwisko", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Pytania", btn_send: "Wyślij"
            },
            hu: {
                nav_back: "Vissza", hero_title: "A STAR Módszer", hero_desc: "Útmutató az interjúválaszok strukturálásához.",
                intro_title: "Mi a STAR módszer?", intro_text: "Strukturált technika kompetencia alapú kérdések megválaszolására.",
                star_s: "Szituáció", desc_s: "Írja le röviden a hátteret vagy a problémát.",
                star_t: "Feladat", desc_t: "Mi volt a cél? Mit akart elérni?",
                star_a: "Akció", desc_a: "A legfontosabb rész. Írja le, mit tett ÖN.",
                star_r: "Eredmény", desc_r: "Ossza meg az eredményt. Számszerűsítse, ha lehet.",
                ex_title: "Példa", ex_q_label: "Kérdés:", ex_q_text: "\"Írjon le egy esetet, amikor nagy munkaterhelése volt.\"",
                bad_lbl: "❌ Gyenge:", bad_txt: "\"Sok vizsgám volt. Nehéz volt, de megcsináltam.\"",
                good_lbl: "✅ STAR:", good_txt: "(Szituáció) 3 határidőm volt. (Feladat) Jó jegyek kellenek. (Akció) Beosztást készítettem. (Eredmény) Kiválóan végeztem.",
                quiz_title: "Teszt",
                q1: "1. Melyik rész legyen a leghosszabb?", q1_a: "A) Szituáció", q1_b: "B) Eredmény", q1_c: "C) Akció",
                q2: "2. Melyik szót használja az 'Akcióban'?", q2_a: "A) \"Mi\"", q2_b: "B) \"Én\"", q2_c: "C) \"Ők\"",
                q3: "3. Mit tartalmazzon az 'Eredmény'?", q3_a: "A) \"Jól ment\"", q3_b: "B) Konkrét eredmények",
                cta_text: "Gyakorolna?", cta_btn: "Próbainterjú Foglalása",
                form_header: "Segítség?", form_sub: "Lépjen kapcsolatba velünk.",
                lbl_name: "Teljes Név", lbl_phone: "Telefon", lbl_email: "Email", lbl_msg: "Kérdések", btn_send: "Küldés"
            },
            es: {
                nav_back: "Volver", hero_title: "El Método STAR", hero_desc: "Guía para estructurar respuestas en entrevistas.",
                intro_title: "¿Qué es el Método STAR?", intro_text: "Técnica estructurada para responder preguntas de competencia.",
                star_s: "Situación", desc_s: "Describe brevemente el contexto o problema.",
                star_t: "Tarea", desc_t: "¿Cuál era el objetivo? ¿Qué intentabas lograr?",
                star_a: "Acción", desc_a: "La parte más importante. Describe qué hiciste TÚ.",
                star_r: "Resultado", desc_r: "Comparte el resultado. Cuantifícalo si es posible.",
                ex_title: "Ejemplo Real", ex_q_label: "Pregunta:", ex_q_text: "\"Describe un momento con mucha carga de trabajo.\"",
                bad_lbl: "❌ Débil:", bad_txt: "\"Tenía muchos exámenes. Fue duro pero trabajé más.\"",
                good_lbl: "✅ STAR:", good_txt: "(Situación) Tenía 3 plazos. (Tarea) Mantener notas. (Acción) Creé un horario. (Resultado) Obtuve Distinción.",
                quiz_title: "Prueba tu Conocimiento",
                q1: "1. ¿Qué parte debe ser más larga?", q1_a: "A) Situación", q1_b: "B) Resultado", q1_c: "C) Acción",
                q2: "2. ¿Qué palabra usar en 'Acción'?", q2_a: "A) \"Nosotros\"", q2_b: "B) \"Yo\"", q2_c: "C) \"Ellos\"",
                q3: "3. ¿Qué incluir en 'Resultado'?", q3_a: "A) \"Salió bien\"", q3_b: "B) Resultados concretos",
                cta_text: "¿Necesitas practicar?", cta_btn: "Reservar Entrevista",
                form_header: "¿Ayuda?", form_sub: "Contáctanos para coaching.",
                lbl_name: "Nombre Completo", lbl_phone: "Teléfono", lbl_email: "Email", lbl_msg: "Preguntas", btn_send: "Enviar"
            },
            it: {
                nav_back: "Indietro", hero_title: "Il Metodo STAR", hero_desc: "Guida per strutturare le risposte ai colloqui.",
                intro_title: "Cos'è il Metodo STAR?", intro_text: "Tecnica strutturata per rispondere a domande sulle competenze.",
                star_s: "Situazione", desc_s: "Descrivi brevemente il contesto o il problema.",
                star_t: "Compito", desc_t: "Qual era l'obiettivo? Cosa volevi ottenere?",
                star_a: "Azione", desc_a: "La parte più importante. Descrivi cosa hai fatto TU.",
                star_r: "Risultato", desc_r: "Condividi il risultato. Quantificalo se possibile.",
                ex_title: "Esempio Reale", ex_q_label: "Domanda:", ex_q_text: "\"Descrivi un momento con molto lavoro.\"",
                bad_lbl: "❌ Debole:", bad_txt: "\"Avevo molti esami. È stata dura ma ce l'ho fatta.\"",
                good_lbl: "✅ STAR:", good_txt: "(Situazione) Avevo 3 scadenze. (Compito) Mantenere i voti. (Azione) Ho creato un orario. (Risultato) Ottimi voti.",
                quiz_title: "Test",
                q1: "1. Quale parte deve essere più lunga?", q1_a: "A) Situazione", q1_b: "B) Risultato", q1_c: "C) Azione",
                q2: "2. Che parola usare in 'Azione'?", q2_a: "A) \"Noi\"", q2_b: "B) \"Io\"", q2_c: "C) \"Loro\"",
                q3: "3. Cosa includere in 'Risultato'?", q3_a: "A) \"È andata bene\"", q3_b: "B) Risultati concreti",
                cta_text: "Vuoi fare pratica?", cta_btn: "Prenota Colloquio",
                form_header: "Aiuto?", form_sub: "Contattaci.",
                lbl_name: "Nome Completo", lbl_phone: "Telefono", lbl_email: "Email", lbl_msg: "Domande", btn_send: "Invia"
            },
            pt: {
                nav_back: "Voltar", hero_title: "O Método STAR", hero_desc: "Guia para estruturar respostas em entrevistas.",
                intro_title: "O que é o Método STAR?", intro_text: "Técnica estruturada para perguntas comportamentais.",
                star_s: "Situação", desc_s: "Descreva brevemente o contexto ou problema.",
                star_t: "Tarefa", desc_t: "Qual era o objetivo? O que tentou alcançar?",
                star_a: "Ação", desc_a: "A parte mais importante. Descreva o que VOCÊ fez.",
                star_r: "Resultado", desc_r: "Compartilhe o resultado. Quantifique se possível.",
                ex_title: "Exemplo Real", ex_q_label: "Pergunta:", ex_q_text: "\"Descreva um momento de muito trabalho.\"",
                bad_lbl: "❌ Fraca:", bad_txt: "\"Tinha muitos exames. Foi difícil, mas consegui.\"",
                good_lbl: "✅ STAR:", good_txt: "(Situação) Tinha 3 prazos. (Tarefa) Manter notas. (Ação) Criei um horário. (Resultado) Notas máximas.",
                quiz_title: "Teste seu Conhecimento",
                q1: "1. Qual parte deve ser mais longa?", q1_a: "A) Situação", q1_b: "B) Resultado", q1_c: "C) Ação",
                q2: "2. Que palavra usar em 'Ação'?", q2_a: "A) \"Nós\"", q2_b: "B) \"Eu\"", q2_c: "C) \"Eles\"",
                q3: "3. O que incluir em 'Resultado'?", q3_a: "A) \"Correu bem\"", q3_b: "B) Resultados concretos",
                cta_text: "Precisa praticar?", cta_btn: "Agendar Entrevista",
                form_header: "Ajuda?", form_sub: "Contacte-nos.",
                lbl_name: "Nome Completo", lbl_phone: "Telefone", lbl_email: "Email", lbl_msg: "Perguntas", btn_send: "Enviar"
            },
            el: {
                nav_back: "Πίσω", hero_title: "Η Μέθοδος STAR", hero_desc: "Οδηγός για τη δομή απαντήσεων σε συνεντεύξεις.",
                intro_title: "Τι είναι η STAR;", intro_text: "Δομημένη τεχνική για ερωτήσεις ικανότητας.",
                star_s: "Κατάσταση", desc_s: "Περιγράψτε το πλαίσιο ή το πρόβλημα.",
                star_t: "Έργο", desc_t: "Ποιος ήταν ο στόχος;",
                star_a: "Δράση", desc_a: "Το πιο σημαντικό. Τι κάνατε ΕΣΕΙΣ.",
                star_r: "Αποτέλεσμα", desc_r: "Μοιραστείτε το αποτέλεσμα.",
                ex_title: "Παράδειγμα", ex_q_label: "Ερώτηση:", ex_q_text: "\"Περιγράψτε φόρτο εργασίας.\"",
                bad_lbl: "❌ Αδύναμη:", bad_txt: "\"Είχα πολλές εξετάσεις. Δούλεψα σκληρά.\"",
                good_lbl: "✅ STAR:", good_txt: "(Κατάσταση) 3 προθεσμίες. (Έργο) Βαθμοί. (Δράση) Πρόγραμμα. (Αποτέλεσμα) Επιτυχία.",
                quiz_title: "Τεστ",
                q1: "1. Ποιο μέρος είναι μεγαλύτερο;", q1_a: "A) Κατάσταση", q1_b: "B) Αποτέλεσμα", q1_c: "C) Δράση",
                q2: "2. Τι λέξη χρησιμοποιούμε στη 'Δράση';", q2_a: "A) \"Εμείς\"", q2_b: "B) \"Εγώ\"", q2_c: "C) \"Αυτοί\"",
                q3: "3. Τι περιλαμβάνει το 'Αποτέλεσμα';", q3_a: "A) \"Πήγε καλά\"", q3_b: "B) Συγκεκριμένα αποτελέσματα",
                cta_text: "Χρειάζεστε εξάσκηση;", cta_btn: "Κράτηση Συνέντευξης",
                form_header: "Βοήθεια;", form_sub: "Επικοινωνήστε μαζί μας.",
                lbl_name: "Ονοματεπώνυμο", lbl_phone: "Τηλέφωνο", lbl_email: "Email", lbl_msg: "Ερωτήσεις", btn_send: "Αποστολή"
            },
            bg: {
                nav_back: "Назад", hero_title: "Методът STAR", hero_desc: "Ръководство за структуриране на отговори.",
                intro_title: "Какво е STAR?", intro_text: "Техника за отговори на поведенчески въпроси.",
                star_s: "Ситуация", desc_s: "Опишете контекста или проблема.",
                star_t: "Задача", desc_t: "Каква беше целта?",
                star_a: "Действие", desc_a: "Най-важната част. Какво направихте ВИЕ.",
                star_r: "Резултат", desc_r: "Споделете резултата.",
                ex_title: "Пример", ex_q_label: "Въпрос:", ex_q_text: "\"Опишете голямо натоварване.\"",
                bad_lbl: "❌ Слабо:", bad_txt: "\"Имах много изпити. Беше трудно, но се справих.\"",
                good_lbl: "✅ STAR:", good_txt: "(Ситуация) 3 крайни срока. (Задача) Оценки. (Действие) График. (Резултат) Отличен.",
                quiz_title: "Тест",
                q1: "1. Коя част е най-дълга?", q1_a: "A) Ситуация", q1_b: "B) Резултат", q1_c: "C) Действие",
                q2: "2. Каква дума ползвате в 'Действие'?", q2_a: "A) \"Ние\"", q2_b: "B) \"Аз\"", q2_c: "C) \"Те\"",
                q3: "3. Какво включва 'Резултат'?", q3_a: "A) \"Мина добре\"", q3_b: "B) Конкретни резултати",
                cta_text: "Нужда от практика?", cta_btn: "Запази Интервю",
                form_header: "Помощ?", form_sub: "Свържете се с нас.",
                lbl_name: "Име", lbl_phone: "Телефон", lbl_email: "Имейл", lbl_msg: "Въпроси", btn_send: "Изпрати"
            }
        };

        function toggleLangMenu() {
            document.getElementById('lang-dropdown').classList.toggle('active');
        }

        function setLang(lang) {
            const langNames = { en:"English", ro:"Română", pl:"Polski", hu:"Magyar", es:"Español", it:"Italiano", pt:"Português", el:"Ελληνικά", bg:"Български" };
            document.getElementById('current-lang').innerText = langNames[lang];
            document.getElementById('lang-dropdown').classList.remove('active');
            
            const t = translations[lang] || translations['en'];
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if(t[key]) el.innerHTML = t[key];
            });
        }

        // Quiz Logic
        let score = 0;
        let answeredCount = 0;
        const totalQuestions = 3;

        function checkAnswer(element, isCorrect) {
            if (element.parentElement.classList.contains('answered')) return;
            element.parentElement.classList.add('answered');
            answeredCount++;

            if (isCorrect) {
                element.classList.add('correct');
                element.innerHTML += ' <i class="fa-solid fa-check-circle" style="margin-left:auto;"></i>';
                score++;
            } else {
                element.classList.add('wrong');
                element.innerHTML += ' <i class="fa-solid fa-times-circle" style="margin-left:auto;"></i>';
                const siblings = element.parentElement.children;
                for (let i = 0; i < siblings.length; i++) {
                    if (siblings[i].getAttribute('onclick').includes('true')) {
                        siblings[i].classList.add('correct');
                        siblings[i].innerHTML += ' <i class="fa-solid fa-check-circle" style="margin-left:auto;"></i>';
                    }
                }
            }

            if (answeredCount === totalQuestions) {
                const scoreBoard = document.getElementById('score-board');
                scoreBoard.style.display = 'block';
                scoreBoard.innerHTML = `You scored ${score} / ${totalQuestions}`;
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.lang-btn') && !event.target.closest('.lang-btn')) {
                var dropdowns = document.getElementsByClassName("lang-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('active')) {
                        openDropdown.classList.remove('active');
                    }
                }
            }
        }
    </script>

</body>
</html>
