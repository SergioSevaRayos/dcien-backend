DROP TABLE IF EXISTS numbers CASCADE;
DROP TABLE IF EXISTS series CASCADE;

CREATE TABLE series (
    id INTEGER PRIMARY KEY
);

CREATE TABLE numbers (
    id SERIAL PRIMARY KEY,
    series_id INTEGER NOT NULL,
    number INTEGER NOT NULL,
    status VARCHAR(16) NOT NULL,
    assigned_order_id INTEGER UNIQUE,
    CONSTRAINT numbers_unique UNIQUE (series_id, number),
    CONSTRAINT numbers_series_fk
        FOREIGN KEY (series_id)
        REFERENCES series (id)
);
