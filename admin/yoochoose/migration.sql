ALTER TABLE `admin_access` ADD COLUMN (`yoochoose` int(1) NOT NULL default '0');
UPDATE `admin_access` SET yoochoose = modules;

INSERT INTO gm_boxes (template_name, box_name, position, box_status)
	VALUES ('EyeCandy', 'yoochoose_also_clicked', 'gm_box_pos_46', 0);

INSERT INTO gm_boxes (template_name, box_name, position, box_status)
	VALUES ('EyeCandy', 'yoochoose_top_selling',  'gm_box_pos_48', 0);

--INSERT INTO gm_boxes (template_name, box_name, position, box_status)
--	VALUES ('gambio', 'yoochoose_also_clicked', 'gm_box_pos_46', 0);

--INSERT INTO gm_boxes (template_name, box_name, position, box_status)
--	VALUES ('gambio', 'yoochoose_top_selling',  'gm_box_pos_48', 0);

INSERT INTO gm_contents (languages_id, gm_key, gm_value)
    VALUES (1, 'YOOCHOOSE_BOX_TOP_SELLING_HEADER', 'Ultimately Bought');
    
INSERT INTO gm_contents (languages_id, gm_key, gm_value) 
    VALUES (2, 'YOOCHOOSE_BOX_TOP_SELLING_HEADER', 'Anschlieﬂend gekauft');
    
INSERT INTO gm_contents (languages_id, gm_key, gm_value) 
    VALUES (1, 'YOOCHOOSE_BOX_ALSO_CLICKED_HEADER', 'Also Viewed');
    
INSERT INTO gm_contents (languages_id, gm_key, gm_value) 
    VALUES (2, 'YOOCHOOSE_BOX_ALSO_CLICKED_HEADER', 'Schauen Sie sich auch an');
