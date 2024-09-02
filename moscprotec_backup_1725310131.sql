

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO user VALUES("1","Tawsif Torabi","tawsifturabi@gmail.com","","tawsiftorabi","$2y$10$kD9nioUcFiPTST45SXyKN.pBVhULR8syNv/MICug3bwQ4fXNRLLti","","","","user","","1725298656");
INSERT INTO user VALUES("2","Admin","admin@localhost","","admin","$2y$10$kD9nioUcFiPTST45SXyKN.pBVhULR8syNv/MICug3bwQ4fXNRLLti","","","","admin","","0");
INSERT INTO user VALUES("4","Torabi Tawsif","tawsif@gmail.com","1234567890","","$2y$10$HUhx.6SbZDP.eAJ6v.qB1edQRHxCj6Qm/LyU0pzDEqhhXFKu5YWRK","12-2-2000","A ","Male","general","","0");
INSERT INTO user VALUES("5","Tawsif Ali","ali@ali.com","1234567890","","$2y$10$HWr5enSfNt6mRqm0k1FYpeXUJlyJPhatF8rpb3NW0aE9wDxoCfUm2","2024-09-06","A+","Male","general","","0");
INSERT INTO user VALUES("6","Babor","wearelookingfor@shotr.uz","1234567890","","$2y$10$aAvoMT/fgeQNr8rA/IznXOx5O89JDWshhohN2grtZkgUEmhkMrf6G","2024-09-27","B+","Male","general","","0");
INSERT INTO user VALUES("7","Babor BNP","wearelookingfor@shotru.bnp","1234567890","","$2y$10$9LQiiDllJjxXhfSI/Ar.oe.0V9TRdtRCkVoApqVNpzu8oHVtpFQem","2024-09-02","A+","Male","general","","0");
INSERT INTO user VALUES("8","Jhaka","naka@jhaka.naka","1234567890","","$2y$10$dbA1dHac2hP//8vGgJLvzecKCHblGn254A3GDyNJIpCLPD8ylARrW","2024-09-09","A+","Male","general","","1725278643");

