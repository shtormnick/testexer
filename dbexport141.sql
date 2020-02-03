--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)
-- Dumped by pg_dump version 11.5 (Ubuntu 11.5-1.pgdg18.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: clicks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.clicks (
    resource_id integer NOT NULL,
    count integer,
    ip character varying(40),
    click_time timestamp without time zone,
    visit_id integer NOT NULL,
    date date
);


--
-- Name: clicks_visit_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.clicks_visit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: clicks_visit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.clicks_visit_id_seq OWNED BY public.clicks.visit_id;


--
-- Name: resource; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.resource (
    id integer NOT NULL,
    category character varying(50) NOT NULL,
    status character varying(50) NOT NULL,
    resource_url character varying(255) NOT NULL,
    resource_name character varying(255) NOT NULL,
    user_id integer NOT NULL
);


--
-- Name: resource_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.resource_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: resource_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.resource_id_seq OWNED BY public.resource.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id integer NOT NULL,
    login character varying(90) NOT NULL,
    password character varying(32) NOT NULL,
    contact character varying(255)
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: visits; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.visits (
    resource_id integer NOT NULL,
    count integer,
    visit_time timestamp without time zone NOT NULL,
    visit_id integer NOT NULL,
    ip character varying(40) NOT NULL,
    date date NOT NULL
);


--
-- Name: visits_visit_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.visits_visit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: visits_visit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.visits_visit_id_seq OWNED BY public.visits.visit_id;


--
-- Name: clicks visit_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.clicks ALTER COLUMN visit_id SET DEFAULT nextval('public.clicks_visit_id_seq'::regclass);


--
-- Name: resource id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resource ALTER COLUMN id SET DEFAULT nextval('public.resource_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: visits visit_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visits ALTER COLUMN visit_id SET DEFAULT nextval('public.visits_visit_id_seq'::regclass);


--
-- Data for Name: clicks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.clicks (resource_id, count, ip, click_time, visit_id, date) FROM stdin;
1	2	192.168.10.10	2020-02-01 11:38:24.949138	140	2020-02-01
3	67	192.168.10.10	2020-02-01 11:26:51.166298	29	2020-02-01
2	129	192.168.10.10	2020-02-01 13:05:44.600039	96	2020-02-01
\.


--
-- Data for Name: resource; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.resource (id, category, status, resource_url, resource_name, user_id) FROM stdin;
1	Video	active	https://www.youtube.com/	Youtube	1
3	Music	no active	https://soundcloud.com/	SoundCloud	5
2	Video	no active	https://www.twitch.tv	Twitch	5
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, login, password, contact) FROM stdin;
1	Nike@gmail.com	c7a5845e9c51b5969b6e8f928ef44c2e	asdasdasd
4	Admin@mail.com	c7a5845e9c51b5969b6e8f928ef44c2e	some text
5	SSS@gmail.com	c7a5845e9c51b5969b6e8f928ef44c2e	some text
9	deqwe@gmail.com	d334f30ba2c612bb2806d531427791a0	qwe
10	DDD@gmail.com	c7a5845e9c51b5969b6e8f928ef44c2e	asdasda
\.


--
-- Data for Name: visits; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.visits (resource_id, count, visit_time, visit_id, ip, date) FROM stdin;
2	36	2020-02-01 13:53:05.718729	152	192.168.10.10	2020-02-01
3	11	2020-02-01 11:30:44.512838	141	192.168.10.10	2020-02-02
3	11	2020-01-31 15:55:09	199	192.168.10.10	2020-01-31
\.


--
-- Name: clicks_visit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.clicks_visit_id_seq', 226, true);


--
-- Name: resource_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resource_id_seq', 8, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 10, true);


--
-- Name: visits_visit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.visits_visit_id_seq', 199, true);


--
-- Name: clicks clicks_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.clicks
    ADD CONSTRAINT clicks_pk UNIQUE (resource_id, ip, date);


--
-- Name: resource resource_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resource
    ADD CONSTRAINT resource_pkey PRIMARY KEY (id);


--
-- Name: users users_login_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_login_key UNIQUE (login);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: visits visits_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_pk UNIQUE (resource_id, ip, date);


--
-- Name: clicks clicks_t_id_id_resource_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.clicks
    ADD CONSTRAINT clicks_t_id_id_resource_fkey FOREIGN KEY (resource_id) REFERENCES public.resource(id) ON DELETE CASCADE;


--
-- Name: resource users_id_resource___fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resource
    ADD CONSTRAINT users_id_resource___fk FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: visits visits_t_id_id_resource_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_t_id_id_resource_fkey FOREIGN KEY (resource_id) REFERENCES public.resource(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

