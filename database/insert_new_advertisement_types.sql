-- Insert new advertisement types for article and category pages
-- Existing advertisement types are ids 68-74 in stp_core_metas (advertisment_type)
-- This adds:
--   - articlePage
--   - categoryPage

INSERT INTO stp_core_metas (core_metaType, core_metaName, core_metaStatus, created_at, updated_at)
VALUES
  ('advertisment_type', 'articlePage', 1, NOW(), NOW()),
  ('advertisment_type', 'categoryPage', 1, NOW(), NOW());

