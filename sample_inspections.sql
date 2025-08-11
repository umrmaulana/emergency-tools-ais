USE emergency_tool;

-- Insert sample inspection data
INSERT INTO tr_inspections (user_id, equipment_id, inspection_date, notes, approval_status) VALUES
(1, 11, '2025-08-10 08:30:00', 'Equipment dalam kondisi baik, tidak ada masalah', 'pending');

INSERT INTO tr_inspections (user_id, equipment_id, inspection_date, notes, approval_status) VALUES  
(1, 12, '2025-08-09 14:15:00', 'Perlu perhatian pada bagian seal', 'pending');

INSERT INTO tr_inspections (user_id, equipment_id, inspection_date, notes, approval_status) VALUES
(2, 13, '2025-08-08 10:45:00', 'Kondisi normal, siap digunakan', 'approved');
