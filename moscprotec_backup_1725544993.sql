

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO chats VALUES("21","11","14","Assalamu Alaikum madam","1","1680909683");
INSERT INTO chats VALUES("22","14","11","Walaikum Salam Torabi","1","1680909693");
INSERT INTO chats VALUES("34","11","14","Madam, I have a query...","1","1680938178");
INSERT INTO chats VALUES("35","11","14","I want to talk about a problem","1","1680938421");
INSERT INTO chats VALUES("36","11","14","Recently I can\'t look into screen properly at night time.","1","1680938446");
INSERT INTO chats VALUES("37","11","14","i need help with that","1","1681022016");
INSERT INTO chats VALUES("38","14","11","Sure son","1","1681422568");
INSERT INTO chats VALUES("39","24","14","Hello doctor","1","1681427606");
INSERT INTO chats VALUES("40","14","24","a","0","1681469165");
INSERT INTO chats VALUES("41","11","20","Assalamu Alaikum","0","1681476956");
INSERT INTO chats VALUES("42","11","16","Assalamu Alaikum Sir","1","1681773540");
INSERT INTO chats VALUES("43","11","27","maam, I need help about some oop problems.","0","1682422864");
INSERT INTO chats VALUES("44","16","14","Helo Doctor","1","1682783099");
INSERT INTO chats VALUES("45","16","23","Hello","0","1683019081");
INSERT INTO chats VALUES("46","16","10","What is going on?","0","1683019111");
INSERT INTO chats VALUES("47","16","8","Test Test","0","1683019121");
INSERT INTO chats VALUES("48","16","8","Test Test\r\n","0","1683019123");
INSERT INTO chats VALUES("49","16","3","Text Test 1","0","1683019130");
INSERT INTO chats VALUES("50","16","21","You send a request for a counseling?","0","1683019148");
INSERT INTO chats VALUES("51","11","13","Hello","0","1684060369");
INSERT INTO chats VALUES("52","11","26","assalamu alaikum","0","1684060399");
INSERT INTO chats VALUES("53","11","26","hello","0","1702369942");
INSERT INTO chats VALUES("54","11","16","hello","1","1702369950");



CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL,
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO conversations VALUES("1","11","14");
INSERT INTO conversations VALUES("5","13","14");
INSERT INTO conversations VALUES("6","24","14");
INSERT INTO conversations VALUES("7","11","20");
INSERT INTO conversations VALUES("8","11","16");
INSERT INTO conversations VALUES("9","11","27");
INSERT INTO conversations VALUES("10","16","14");
INSERT INTO conversations VALUES("11","16","23");
INSERT INTO conversations VALUES("12","16","10");
INSERT INTO conversations VALUES("13","16","8");
INSERT INTO conversations VALUES("14","16","3");
INSERT INTO conversations VALUES("15","16","21");
INSERT INTO conversations VALUES("16","11","13");
INSERT INTO conversations VALUES("17","11","26");



CREATE TABLE `medical_blood_donation_record` (
  `donate_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `last_donated` varchar(255) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`donate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO medical_blood_donation_record VALUES("2","3","1678654364","");
INSERT INTO medical_blood_donation_record VALUES("19","13","1679936275","<p>Today I witnessed a heartwarming incident at the blood donation center. A young woman, who was afraid of needles, gathered the courage to donate blood after hearing about a patient in need. Her act of kindness inspired others in the waiting room to donate as well. The collective effort resulted in a successful blood drive and a potential life-saving outcome. It was a reminder of the power of empathy and how one selfless act can make a difference. Haha</p>");
INSERT INTO medical_blood_donation_record VALUES("22","11","1702582442","");



CREATE TABLE `medical_patient_profile` (
  `user_id` int(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `medical_prescription` (
  `prescrption_id` int(255) NOT NULL AUTO_INCREMENT,
  `token_id` int(255) NOT NULL,
  `prescription` text NOT NULL,
  PRIMARY KEY (`prescrption_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO medical_prescription VALUES("8","15","<p>Medication:</p>\r\n<ol>\r\n<li>Albuterol inhaler, 2 puffs every 4-6 hours as needed for asthma symptoms.</li>\r\n<li>Fluticasone nasal spray, 1 spray in each nostril daily for allergic rhinitis.</li>\r\n</ol>\r\n<p>Instructions:</p>\r\n<ul>\r\n<li>Take medications as prescribed.</li>\r\n<li>Use the Albuterol inhaler as needed for shortness of breath, wheezing, or chest tightness. It should be used with a spacer device for optimal delivery of the medication.</li>\r\n<li>Use the Fluticasone nasal spray every day at the same time to reduce inflammation in the nasal passages. It may take several days to notice the full effect.</li>\r\n<li>Rinse your mouth with water after using the Albuterol inhaler to prevent thrush.</li>\r\n</ul>\r\n<p>Side Effects: Albuterol may cause rapid heartbeat, tremors, or nervousness. It may also cause low potassium levels in rare cases. Fluticasone may cause nosebleeds, headache, or sore throat. In rare cases, it may increase the risk of cataracts or glaucoma.</p>\r\n<p>Follow-up: Please schedule a follow-up appointment in 4-6 weeks to assess your progress and adjust the treatment plan if necessary.</p>");
INSERT INTO medical_prescription VALUES("9","16","<p>Medication:</p>\r\n<ol>\r\n<li>Ibuprofen 400mg, 1 tablet every 6 hours as needed for pain relief.</li>\r\n<li>Amoxicillin 500mg, 1 tablet 3 times a day for 7 days for treatment of bacterial infection.</li>\r\n<li>Omeprazole 20mg, 1 tablet daily in the morning to reduce stomach acid.</li>\r\n</ol>\r\n<p>Instructions:</p>\r\n<ul>\r\n<li>Take medications as prescribed.</li>\r\n<li>Ibuprofen can be taken with food or milk to reduce stomach upset.</li>\r\n<li>Finish the entire course of Amoxicillin even if symptoms improve.</li>\r\n<li>Omeprazole should be taken on an empty stomach 30 minutes before breakfast.</li>\r\n</ul>\r\n<p>Side Effects: Ibuprofen may cause stomach upset, nausea, or vomiting. It may also increase the risk of bleeding, especially in people who have bleeding disorders or take blood thinners. Amoxicillin may cause diarrhea, nausea, or vomiting. In rare cases, it may cause an allergic reaction, such as rash or swelling. Omeprazole may cause headache, diarrhea, or stomach pain. In rare cases, it may increase the risk of bone fractures or infections.</p>\r\n<p>Follow-up: Please schedule a follow-up appointment in 2 weeks to assess your progress and adjust the treatment plan if necessary.</p>");



CREATE TABLE `medical_tokens` (
  `token_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `week_day` varchar(4) NOT NULL,
  `date` varchar(255) NOT NULL,
  `problem` text NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `attendance` varchar(20) NOT NULL,
  `validity` varchar(20) NOT NULL,
  `createDateTime` varchar(255) NOT NULL,
  PRIMARY KEY (`token_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO medical_tokens VALUES("15","13","Sat","2022-12-31","Dear Doctor,</br> I am writing to seek your medical advice regarding a health concern that I have been experiencing. Lately, I have been having frequent headaches accompanied by dizziness and nausea. These symptoms have been affecting my daily routine and productivity, and I am becoming increasingly concerned about my health. I have tried taking over-the-counter painkillers, but they only provide temporary relief. I have also tried getting more rest and drinking plenty of water, but the symptoms persist. I would greatly appreciate it if you could provide me with a diagnosis and treatment plan for my condition. I am available to schedule an appointment at your earliest convenience. Thank you for your time and consideration","0a9ebb14a120b957fa1899f1f3852ded","yes","invalid","1672514238");
INSERT INTO medical_tokens VALUES("16","11","Sat","2022-12-31","Dear Doctor, </br>I hope this letter finds you in good health. </br> I am writing to seek your medical advice regarding a health issue that I have been facing recently. For the past few days, I have been experiencing a persistent headache and a mild fever. I have also been feeling fatigued and have lost my appetite. I have tried taking over-the-counter painkillers, but they have not provided any relief. I am concerned about these symptoms and would appreciate it if you could provide me with your expert opinion on what might be causing them and what steps I should take to address them. Thank you for your time and attention. I look forward to hearing from you soon. ","null","yes","invalid","1672524330");
INSERT INTO medical_tokens VALUES("17","11","Sat","2022-12-31","Dear Doctor, </br>I hope this letter finds you well. I am writing to seek your medical advice regarding a health issue that I have been experiencing. For the past few weeks, I have been experiencing persistent headaches and occasional dizziness. The headaches are usually located at the back of my head and are accompanied by a feeling of pressure. I have also noticed that my vision has been slightly blurry at times. I am concerned about these symptoms and would appreciate your professional opinion on what may be causing them. I would also like to know if there are any tests or treatments that you would recommend. Thank you for taking the time to read my letter. I look forward to hearing from you soon.","43567ec252fa846f8dc621af9f91d583","yes","invalid","1672524514");
INSERT INTO medical_tokens VALUES("19","11","Sat","2022-12-31","Dear Doctor, </br>I am writing to seek your professional help regarding my ADHD problem. I have been experiencing symptoms of inattention, hyperactivity and impulsivity which have been affecting my daily life and productivity. I have tried various methods to manage my symptoms such as exercise, meditation and time management techniques, but they have not been effective. I believe that I need medical intervention to manage my ADHD symptoms. I would appreciate it if you could provide me with a thorough evaluation and diagnosis of my condition, and recommend appropriate treatment options. I am open to medication or therapy, or any other treatment that you may suggest. Thank you for your time and consideration. I look forward to hearing from you soon. ","null","no","invalid","1672525011");
INSERT INTO medical_tokens VALUES("20","11","Sat","2022-12-31","Dear Doctor,</br> I am writing to seek your help regarding my ADHD problem. I have been struggling with attention deficit hyperactivity disorder for quite some time now, and it has been affecting my daily life and productivity. I have tried various methods to manage my symptoms, such as meditation and exercise, but they have not been effective enough. I am hoping that with your expertise and guidance, I can find a more effective solution to manage my ADHD. I would greatly appreciate it if we could schedule a consultation to discuss my condition and potential treatment options. Please let me know if this is possible and what the next steps would be. Thank you for your time and consideration.","null","no","invalid","1672525093");
INSERT INTO medical_tokens VALUES("22","11","Sat","2022-12-31","Dear Doctor,</br> I am writing to seek your medical advice regarding a persistent stomach pain that I have been experiencing for the past few days. The pain is located in the upper part of my abdomen and it is accompanied by bloating and discomfort. I have tried taking over-the-counter medications such as antacids and pain relievers, but they seem to provide only temporary relief. The pain returns after a few hours. I am concerned that this may be a serious condition and I would appreciate it if you could provide me with a diagnosis and treatment plan. I am available for an appointment at your earliest convenience. Thank you for your time and consideration. ","1680037943-116423583741d1c","yes","invalid","1672525265");
INSERT INTO medical_tokens VALUES("27","9","Fri","2023-3-10","<p>Dear Dr. Shamima Akhter,</p>\r\n<p>I am writing to you to discuss a sample problem that I have been experiencing lately. My name is Tawsif Torabi, and I am a patient of yours who has been receiving treatment for a while now. However, I have noticed a recent change in my health condition that I wanted to bring to your attention.</p>\r\n<p>Over the past few weeks, I have been experiencing a recurring pain in my lower abdomen, which seems to be increasing in intensity. I have also noticed some irregularity in my bowel movements, which has been causing me a lot of discomfort and concern. As someone who has always been mindful of my health, this has been particularly distressing for me.</p>\r\n<p>Given my history with you as my healthcare provider, I wanted to reach out and discuss this matter with you in the hope that you can offer some guidance on how to manage this issue. I am aware that your schedule may be busy, but I would be grateful for any advice or recommendations you can provide on how to alleviate this pain and discomfort.</p>\r\n<p>Thank you for your time and attention to this matter, and I look forward to hearing back from you soon.</p>\r\n<p>Sincerely,</p>\r\n<p>Tawsif Torabi</p>","1679143851-116415b3ab32610","yes","invalid","1678479844");
INSERT INTO medical_tokens VALUES("28","3","Sat","2023-3-11","<p>Dear Doctor,</p>\r\n<p>I hope this email finds you well. I am writing to seek your advice about my recurring headaches. Over the past month, I have been experiencing persistent headaches, which have become increasingly frequent and severe.</p>\r\n<p>The headaches usually start in the morning and continue throughout the day, making it difficult for me to concentrate on my work. I have also noticed that they are often accompanied by a feeling of pressure in my forehead and temples, and sometimes by dizziness and nausea.</p>\r\n<p>I have tried over-the-counter painkillers like ibuprofen and acetaminophen, but they only provide temporary relief. I have also made some lifestyle changes, such as reducing my caffeine intake and getting more sleep, but these have not made much of a difference.</p>\r\n<p>I am concerned that these headaches may be a symptom of a more serious underlying condition, and I would like to schedule an appointment with you to discuss my symptoms and explore possible treatment options. Please let me know what your availability is like over the next few weeks, and I will be happy to schedule a consultation at your earliest convenience.</p>\r\n<p>Thank you for your time and attention.</p>\r\n<p>Sincerely<br>Talha Beg</p>","1678882740-36411b7b4214e3","yes","invalid","1678518880");
INSERT INTO medical_tokens VALUES("29","8","Mon","2023-3-13","<p>Dear Dr. Shamima Akhter,</p>\r\n<p>I am writing to you to discuss a sample problem that I have been experiencing lately. My name is Tawsif Torabi, and I am a patient of yours who has been receiving treatment for a while now. However, I have noticed a recent change in my health condition that I wanted to bring to your attention.</p>\r\n<p>Over the past few weeks, I have been experiencing a recurring pain in my lower abdomen, which seems to be increasing in intensity. I have also noticed some irregularity in my bowel movements, which has been causing me a lot of discomfort and concern. As someone who has always been mindful of my health, this has been particularly distressing for me.</p>\r\n<p>Thank you for your time and attention to this matter, and I look forward to hearing back from you soon.</p>","1678710300-8640f161c40465","yes","invalid","1678710293");



CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `blood_group` varchar(4) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `pp` varchar(300) NOT NULL,
  `lastseen` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO user VALUES("1","Tawsif Torabi","tawsifturabi@gmail.com","","tawsiftorabi","$2y$10$kD9nioUcFiPTST45SXyKN.pBVhULR8syNv/MICug3bwQ4fXNRLLti","","","","user","","1725541633");
INSERT INTO user VALUES("2","Admin","admin@localhost","","admin","$2y$10$kD9nioUcFiPTST45SXyKN.pBVhULR8syNv/MICug3bwQ4fXNRLLti","","","","admin","","0");
INSERT INTO user VALUES("4","Torabi Tawsif","tawsif@gmail.com","1234567890","","$2y$10$HUhx.6SbZDP.eAJ6v.qB1edQRHxCj6Qm/LyU0pzDEqhhXFKu5YWRK","12-2-2000","A ","Male","general","","0");
INSERT INTO user VALUES("5","Tawsif Ali","ali@ali.com","1234567890","","$2y$10$HWr5enSfNt6mRqm0k1FYpeXUJlyJPhatF8rpb3NW0aE9wDxoCfUm2","2024-09-06","A+","Male","general","","0");
INSERT INTO user VALUES("6","Babor","wearelookingfor@shotr.uz","1234567890","","$2y$10$aAvoMT/fgeQNr8rA/IznXOx5O89JDWshhohN2grtZkgUEmhkMrf6G","2024-09-27","B+","Male","general","","0");
INSERT INTO user VALUES("7","Babor BNP","wearelookingfor@shotru.bnp","1234567890","","$2y$10$9LQiiDllJjxXhfSI/Ar.oe.0V9TRdtRCkVoApqVNpzu8oHVtpFQem","2024-09-02","A+","Male","general","","0");
INSERT INTO user VALUES("8","Jhaka","naka@jhaka.naka","1234567890","","$2y$10$dbA1dHac2hP//8vGgJLvzecKCHblGn254A3GDyNJIpCLPD8ylARrW","2024-09-09","A+","Male","general","","1725278643");



CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `is_valid` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO user_sessions VALUES("5","1","kr1u21mvnjeabc1esvi6k6h3pkp00eq8","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0","::1","0","2024-09-05 11:03:11","2024-09-05 17:03:29");
INSERT INTO user_sessions VALUES("6","1","5c3nrjd54n8hk29mug5glkod0fbqgh86","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0","::1","0","2024-09-05 11:14:12","2024-09-05 17:45:45");
INSERT INTO user_sessions VALUES("7","1","7192u9jcka9kfh0thud800mvlgagm757","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0","::1","0","2024-09-05 11:45:57","2024-09-05 17:46:14");
INSERT INTO user_sessions VALUES("8","1","rtcl55gc50onpdqrhvk1fvcoh5qlrn2h","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0","::1","0","2024-09-05 13:07:13","2024-09-05 19:07:39");



CREATE TABLE `user_settings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `hide_user_bloodbank` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


