-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 22 2022 г., 23:48
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `labor_protection_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id_group` int NOT NULL,
  `title_group` text NOT NULL,
  `course` int NOT NULL,
  `max_course` int NOT NULL,
  `id_specialization` int NOT NULL,
  `elder` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id_group`, `title_group`, `course`, `max_course`, `id_specialization`, `elder`) VALUES
(1, 'ИС-11', 1, 4, 1, ''),
(4, 'ИС-41', 4, 4, 1, 'Папулов'),
(5, 'Д-11', 1, 4, 7, ''),
(6, 'Д-21', 2, 4, 7, ''),
(7, 'Д-31', 3, 4, 7, ''),
(8, 'Д-41', 4, 4, 7, ''),
(9, 'С-11', 1, 4, 6, ''),
(10, 'С-21', 2, 4, 6, ''),
(11, 'С-31', 3, 4, 6, ''),
(12, 'С-41', 4, 4, 6, ''),
(13, 'С-12', 1, 4, 6, ''),
(14, 'С-22', 2, 4, 6, ''),
(15, 'С-32', 3, 4, 6, ''),
(16, 'С-42', 4, 4, 6, ''),
(22, 'ИС-21', 2, 4, 1, ''),
(23, 'ИС-31', 3, 4, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `journals`
--

CREATE TABLE `journals` (
  `id_journal` int NOT NULL,
  `type_victim` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `archive` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `journals`
--

INSERT INTO `journals` (`id_journal`, `type_victim`, `date_start`, `date_end`, `archive`) VALUES
(17, 'students', '2022-06-20', '2022-06-20', 1),
(22, 'staff', '2022-06-20', '2022-06-21', 1),
(23, 'students', '2022-06-20', '2022-06-21', 1),
(26, 'students', '2022-06-22', '1970-01-01', 0),
(27, 'staff', '2022-06-22', '1970-01-01', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `microtraumas`
--

CREATE TABLE `microtraumas` (
  `id_microtr` int NOT NULL,
  `id_student` int NOT NULL,
  `id_staff` int NOT NULL,
  `id_group` int NOT NULL,
  `id_journal` int NOT NULL,
  `place_microtr` text NOT NULL,
  `first_aid` text NOT NULL,
  `date_of_application` datetime NOT NULL,
  `title_medicial` text NOT NULL,
  `duration_release` text NOT NULL,
  `circumstances` text NOT NULL,
  `id_reason` int NOT NULL,
  `custom_reason` text NOT NULL,
  `id_type_main` int NOT NULL,
  `id_type_secondary` int NOT NULL,
  `custom_type` text NOT NULL,
  `suggestions` text NOT NULL,
  `trauma` text NOT NULL,
  `date_microtr` datetime NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `microtraumas`
--

INSERT INTO `microtraumas` (`id_microtr`, `id_student`, `id_staff`, `id_group`, `id_journal`, `place_microtr`, `first_aid`, `date_of_application`, `title_medicial`, `duration_release`, `circumstances`, `id_reason`, `custom_reason`, `id_type_main`, `id_type_secondary`, `custom_type`, `suggestions`, `trauma`, `date_microtr`, `status`) VALUES
(59, 0, 119, 0, 22, 'Спортзал', 'Ссадина продезинфицирована и перевязана ', '2022-06-21 15:00:00', '', '', '', 0, '', 0, 0, '', '', 'Ссадина', '2022-06-21 14:50:00', 'В рассмотрении'),
(63, 416, 0, 4, 26, 'Лестничная площадка', 'Применен холод и наложена давящая повязка', '2022-06-23 14:28:00', '', '', '', 0, '', 0, 0, '', '', 'Ушиб', '2022-06-23 14:22:00', 'В рассмотрении');

-- --------------------------------------------------------

--
-- Структура таблицы `reasons`
--

CREATE TABLE `reasons` (
  `id_reason` int NOT NULL,
  `reason_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `reasons`
--

INSERT INTO `reasons` (`id_reason`, `reason_title`) VALUES
(1, 'Конструктивные недостатки и недостаточная надежность машин, механизмов, оборудования'),
(2, 'Несовершенство технологического процесса'),
(3, 'Эксплуатация неисправных машин, механизмов, оборудования'),
(4, 'Неудовлетворительное техническое состояние зданий, сооружений, территории'),
(5, 'Нарушение технологического процесса'),
(6, 'Нарушение требований безопасности при эксплуатации транспортных средств'),
(7, 'Нарушение правил дорожного движения'),
(8, 'Неудовлетворительное содержание и недостатки в организации рабочих мест'),
(9, 'Недостатки в организации и проведении подготовки работников по охране труда, в т.ч. непроведение инструктажа по охране труда'),
(10, 'Недостатки в организации и проведении подготовки работников по охране труда, в т.ч. непроведение обучения и проверки знаний по охране труда'),
(11, 'Неприменение средств коллективной защиты'),
(12, 'Нарушение работником трудового распорядка и дисциплины труда, в т.ч. нахождение пострадавшего в состоянии алкогольного, наркотического и иного токсического опьянения'),
(13, 'Использование пострадавшего не по специальности'),
(14, 'Прочие причины, квалифицированные по материалам расследования несчастных случаев');

-- --------------------------------------------------------

--
-- Структура таблицы `specializations`
--

CREATE TABLE `specializations` (
  `id_specialization` int NOT NULL,
  `title_specialization` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `specializations`
--

INSERT INTO `specializations` (`id_specialization`, `title_specialization`) VALUES
(1, 'Информационные системы (по отраслям)'),
(2, 'Строительство зданий и сооружений'),
(3, 'Информационные системы и программирование'),
(4, 'Техническая эксплуатация и обслуживание электрического и электромеханического оборудования (по отраслям)'),
(5, 'Техническая эксплуатация подъемнотранспортных, строительных, дорожных машин и оборудования (по отраслям)'),
(6, 'Садово-парковое и ландшафтное строительство'),
(7, 'Дизайн (по отраслям)'),
(8, 'Земельноимущественные отношения'),
(9, 'Документационное обеспечение управления и архивоведения');

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `id_staff` int NOT NULL,
  `FIO` text NOT NULL,
  `img` text NOT NULL,
  `post` text NOT NULL,
  `division` text NOT NULL,
  `personnel_category` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `director` text NOT NULL,
  `date_hiring` date NOT NULL,
  `date_birth` date NOT NULL,
  `SNILS` text NOT NULL,
  `experience` text NOT NULL,
  `email` text NOT NULL,
  `№_passport` text NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `combining` int NOT NULL,
  `disability` int NOT NULL,
  `maternity_leave` int NOT NULL,
  `pregnancy` int NOT NULL,
  `easy_work` int NOT NULL,
  `add_information` text NOT NULL,
  `archive` int NOT NULL,
  `date_archive` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`id_staff`, `FIO`, `img`, `post`, `division`, `personnel_category`, `director`, `date_hiring`, `date_birth`, `SNILS`, `experience`, `email`, `№_passport`, `address`, `combining`, `disability`, `maternity_leave`, `pregnancy`, `easy_work`, `add_information`, `archive`, `date_archive`) VALUES
(1, 'Ковылев Иван Сергеевич', '/assets/img/staff/1/anon.jpg', 'Преподаватель истории', 'Отделение строительства и дизайна', '', '', '2000-11-23', '1995-05-15', '', '5 лет', '', '', '', 1, 0, 0, 0, 0, '', 0, '1970-01-01'),
(119, 'Петров Егор Алексеевич', '/assets/img/staff/119/anon.jpg', 'Преподаватель УИФИС', 'Отделение строительства и дизайна', '', '', '2020-06-15', '1994-01-15', '435365465', '3 года', '23432432@df.asdf', '1234321432', '-', 0, 0, 0, 0, 0, '', 0, '1970-01-01');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id_student` int NOT NULL,
  `FIO` text NOT NULL,
  `img` text NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `id_group` int NOT NULL,
  `admission_to_study` date NOT NULL,
  `date_birth` date NOT NULL,
  `add_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archive` int NOT NULL,
  `date_archive` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id_student`, `FIO`, `img`, `address`, `phone`, `id_group`, `admission_to_study`, `date_birth`, `add_information`, `archive`, `date_archive`) VALUES
(3, 'Гизатуллин Тимур Айдарович', '/assets/img/students/3/Гизатуллин Тимур Айдарович.bmp', 'ул. Ленина, д. 152, кв. 95', 'fdsafdsa', 4, '2019-08-05', '2001-09-11', 'dsafdsafdsasafsdafdsa', 1, '1970-01-01'),
(415, 'Бородин Данил Алексеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(416, 'Бурсин Марк Аркадьевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(417, 'Ершов Владимир Игоревич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(418, 'Желтухин Дмитрий Олегович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(419, 'Комаров Сергей Игоревич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(420, 'Котелевец Данил Сергеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(421, 'Леконцев Никита Вячеславович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(422, 'Маковеев Андрей Максимович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(423, 'Нигаматьянов Мирсал Денисович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(424, 'Палкина Анастасия Андреевна', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(425, 'Папулов Гурген Леванович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(426, 'Попов Кирилл Сергеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(427, 'Пытьков Дмитрий Валерьевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(428, 'Русских Сергей Алексеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(429, 'Скрябина Полина Алексеевна', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(430, 'Филиппов Артем Михайлович', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(431, 'Филиппов Семен Евгеньевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(432, 'Чачин Алексей Анатольевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(433, 'Черных Дмитрий Сергеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(434, 'Шемпелев Вадим Дмитриевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01'),
(439, 'Агафонов Александр Сергеевич', '', '', '', 4, '1970-01-01', '1970-01-01', '', 0, '1970-01-01');

-- --------------------------------------------------------

--
-- Структура таблицы `types_main`
--

CREATE TABLE `types_main` (
  `id_type_main` int NOT NULL,
  `type_main_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `types_main`
--

INSERT INTO `types_main` (`id_type_main`, `type_main_title`) VALUES
(1, 'Транспортные происшествия, в т.ч.'),
(2, 'Падение пострадавшего с высоты, в т.ч.'),
(3, 'Падение, обрушение, обвалы предметов, материалов, земли и пр., в т.ч.'),
(4, 'Воздействие движущихся, разлетающихся, вращающихся предметов,\r\nдеталей, машин и т.д.,'),
(5, 'Попадание инородного тела'),
(6, 'Физические перегрузки и перенапряжения'),
(7, 'Воздействие электрического тока, в т.ч.'),
(8, 'Воздействие излучений (ионизирующих и неионизирующих)'),
(9, 'Воздействие экстремальных температур и других природных факторов'),
(10, 'Воздействие дыма, огня и пламени'),
(11, 'Воздействие вредных веществ'),
(12, 'Повреждения в результате нервно-психологических нагрузок и\r\nвременных лишений длительное отсутствие пиши, воды и т.д.)'),
(13, 'Повреждения в результате контакта с растениями, животными, насекомыми и пресмыкающимися'),
(14, 'Утопление и погружение в воду, в т.ч.'),
(15, 'Повреждения в результате противоправных действий других лиц'),
(16, 'Повреждения в результате преднамеренных действий по причинению вреда собственному здоровью (самоповреждения и самоубийства)'),
(17, 'Повреждения при чрезвычайных ситуациях природного, техногенного, криминогенного и иного характера, в т.ч.'),
(18, 'Воздействие других неклассифицированных травмирующих факторов');

-- --------------------------------------------------------

--
-- Структура таблицы `types_secondary`
--

CREATE TABLE `types_secondary` (
  `id_type_secondary` int NOT NULL,
  `type_secondary_title` text NOT NULL,
  `id_type_main` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `types_secondary`
--

INSERT INTO `types_secondary` (`id_type_secondary`, `type_secondary_title`, `id_type_main`) VALUES
(1, ' на железнодорожном транспорте', 1),
(2, ' на водном транспорте', 1),
(3, ' на воздушном транспорте', 1),
(4, ' на наземном транспорте', 1),
(5, ' происшедшие: в пути на работу (с работы) на транспортном средстве работодателя\r\n(или сторонней организации на основании договора с работодателем)', 1),
(6, ' происшедшие: во время служебных поездок (в т.ч. в пути следования в служебную командировку) на общественном транспорте', 1),
(7, ' происшедшие: во время служебных поездок на личном транспортном средстве', 1),
(8, ' происшедшие: во время пешеходного передвижения к месту работы', 1),
(9, ' падение на ровной поверхности одного уровня, включая: падение на скользкой поверхности, в том числе покрытой снегом или льдом', 2),
(10, ' падение на ровной поверхности одного уровня, включая: падение на поверхности одного уровня в результате проскальзывания,\r\nложного шага или спотыкания', 2),
(11, ' падение при разности уровней высот (с деревьев, мебели, со ступеней,\r\nприставных лестниц, строительных лесов, зданий, оборудования, транспортных средств и т.д.) и на глубину (в шахты, ямы, рытвины и др.)', 2),
(12, ' падение, обрушение, обвалы предметов, материалов, земли и пр., в т.ч.', 3),
(13, ' обрушение и осыпь земляных масс, скал, камней, снега и др.', 3),
(14, ' обвалы зданий, стен, строительных лесов, лестниц, складированных\r\nтоваров и др.', 3),
(15, ' удары падающими предметами и деталями (включая их осколки и частицы) при работе (обращении) с ними', 3),
(16, ' удары случайными падающими предметами', 3),
(17, ' контактные удары (ушибы) при столкновении с движущимися предметами, деталями и машинами (за исключением случаев падения\r\nпредметов и деталей), в том числе в результате взрыва', 4),
(18, ' контактные удары (ушибы) при столкновении с неподвижными предметами, деталями и машинами, в том числе в результате взрыва', 4),
(19, ' защемление между неподвижными и движущимися предметами, деталями и машинами (или между ними)', 4),
(20, ' защемление между движущимися предметами, деталями и машинами (за исключением летящих или падающих предметов, деталей и машин)', 4),
(21, ' прочие контакты (столкновения) с предметами, деталями и машинами (за исключением ударов (ушибов) от падающих предметов)', 4),
(22, ' через естественные отверстия в организме', 5),
(23, ' через кожу (край или обломок другого предмета, заноза и т.п.)', 5),
(24, ' вдыхание и заглатывание пищи либо инородного предмета, приводящее к закупорке дыхательных путей', 5),
(25, ' чрезмерные физические усилия при подъеме предметов и деталей', 6),
(26, ' чрезмерные физические усилия при толкании или демонтировании предметов и деталей', 6),
(27, ' чрезмерные физические усилия при переноске или бросании предметов', 6),
(28, ' природного электричества (молнии)', 7),
(29, ' воздействие повышенной температуры воздуха окружающей или рабочей среды', 9),
(30, ' воздействие пониженной температуры воздуха окружающей или рабочей среды', 9),
(31, ' соприкосновение с горячими и раскаленными частями оборудования, предметами или материалами, включая воздействие пара и горячей воды', 9),
(32, ' соприкосновение с чрезмерно холодными частями оборудования, предметами и материалами', 9),
(33, ' воздействие высокого или низкого атмосферного давления', 9),
(34, ' воздействие неконтролируемого огня (пожара) в здании или сооружении', 10),
(35, ' воздействие неконтролируемого огня (пожара) вне здания или сооружения, в том числе пламени от костра', 10),
(36, ' воздействие контролируемого огня в здании или сооружении (огня в печи, камине и т.д.)', 10),
(37, ' повреждения при возгорании легковоспламеняющихся веществ и одежды', 10),
(38, ' воздействие вредных веществ путем вдыхания, попадания внутрь или абсорбции в результате неправильного их применения или обращения с ними', 11),
(39, ' воздействие вредных веществ (в том числе алкоголя, наркотических, токсических или иных психотропных средств) в результате передозировки или злоупотребления при их использовании', 11),
(40, ' укусы, удары и другие повреждения, нанесенные животными и пресмыкающимися', 13),
(41, ' укусы и ужаливания ядовитых животных, насекомых и пресмыкающихся', 13),
(42, ' повреждения в результате контакта с колючками и шипами колючих и ядовитых растений', 13),
(43, ' во время нахождения в естественном или искусственном водоеме', 14),
(44, ' в результате падения в естественный или искусственный водоем', 14),
(45, ' в результате землетрясений, извержений вулканов, снежных обвалов, оползней и подвижек грунта, шторма, наводнения и др.', 17),
(46, ' в результате аварий, взрывов и катастроф техногенного характера', 17),
(47, ' в результате взрывов и разрушений криминогенного характера', 17),
(48, ' при ликвидации последствий стихийных бедствий, катастроф и других чрезвычайных ситуаций природного, техногенного, криминогенного и иного характера', 17);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `nickname` text NOT NULL,
  `role` text NOT NULL,
  `FIO` text NOT NULL,
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login`, `password`, `nickname`, `role`, `FIO`, `post`) VALUES
(1, 'admin', 'bbb64e1f36bb354802ba7e24a79366e2', 'Метелёв', 'admin', 'Александр Юрьевич Метелев', 'Инженер по охране труда'),
(2, 'medical', 'bbb64e1f36bb354802ba7e24a79366e2', 'Мед. кабинет', 'medicial', 'ФИО', 'Медработник');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_group`);

--
-- Индексы таблицы `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id_journal`);

--
-- Индексы таблицы `microtraumas`
--
ALTER TABLE `microtraumas`
  ADD PRIMARY KEY (`id_microtr`);

--
-- Индексы таблицы `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id_reason`);

--
-- Индексы таблицы `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id_specialization`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id_student`);

--
-- Индексы таблицы `types_main`
--
ALTER TABLE `types_main`
  ADD PRIMARY KEY (`id_type_main`);

--
-- Индексы таблицы `types_secondary`
--
ALTER TABLE `types_secondary`
  ADD PRIMARY KEY (`id_type_secondary`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id_group` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `journals`
--
ALTER TABLE `journals`
  MODIFY `id_journal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `microtraumas`
--
ALTER TABLE `microtraumas`
  MODIFY `id_microtr` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT для таблицы `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id_reason` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id_specialization` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id_student` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;

--
-- AUTO_INCREMENT для таблицы `types_main`
--
ALTER TABLE `types_main`
  MODIFY `id_type_main` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `types_secondary`
--
ALTER TABLE `types_secondary`
  MODIFY `id_type_secondary` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
