USE screenroot_feedback;
INSERT INTO feedback (name,email,company,project,overall_rating,communication_rating,design_rating,timeliness_rating,nps_score,went_well,improve,can_contact,created_at) VALUES
('Asha Menon','asha@example.com','Northwind Bank','Mobile app redesign',5,5,5,4,10,'The team understood our users quickly and the prototypes were excellent.','Share the weekly timeline earlier.',1,NOW() - INTERVAL 1 DAY),
('Rohan Desai','rohan@example.com','Kestrel Insurance','Claims portal',4,4,5,3,8,'Strong design thinking and clean handover.','Two milestones slipped by a few days.',1,NOW() - INTERVAL 2 DAY),
('Meera Iyer','meera@example.com','Lumen Health','Patient dashboard',5,5,5,5,10,'Very collaborative and proactive.',NULL,0,NOW() - INTERVAL 4 DAY),
('Karan Shah','karan@example.com','Orbit Pharma','Website revamp',3,3,4,3,6,'Visual design was good.','Communication gaps during the research phase.',1,NOW() - INTERVAL 6 DAY),
('Neha Kulkarni','neha@example.com','Brightway Edu','Learning platform',4,5,4,4,9,'Responsive team, quick turnarounds on feedback.','More documentation on the design system.',0,NOW() - INTERVAL 9 DAY),
('Vikram Rao','vikram@example.com','Atlas Motors','Dealer app',5,4,5,5,9,'Great attention to detail.',NULL,1,NOW() - INTERVAL 12 DAY),
('Priya Nair','priya@example.com','Finlytics','Dashboard UX audit',2,2,3,2,4,'The audit report was thorough.','Kickoff was disorganised and replies were slow.',1,NOW() - INTERVAL 15 DAY),
('Sanjay Patel','sanjay@example.com','Greenfield Mfg','Enterprise ERP UI',4,4,4,4,8,'Handled a complex product well.','Earlier usability testing would have helped.',0,NOW() - INTERVAL 21 DAY),
('Anita D''Souza','anita@example.com','Coastline Travel','Booking flow',5,5,4,5,10,'Delivered ahead of schedule.',NULL,1,NOW() - INTERVAL 27 DAY),
('Farhan Ali','farhan@example.com','Quantix','Trading app',4,5,5,3,7,'Beautiful interface work.','Be firmer on scope changes.',1,NOW() - INTERVAL 40 DAY);
