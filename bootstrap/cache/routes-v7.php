<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::13AuSXuP0vEfkBp2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welcome',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/sms-test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sms.test',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/sms-test/send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sms.test.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/sms-logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eZy8cjITD2sDryEI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/test/ticket-call' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LzPuTbu53L7LuNQa',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/entreprises' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/client/ticket' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.ticket',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Wip52VSq1qOslBQP',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'logout.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/select-company' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'select.company',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/companies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin.companies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/client' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/super-admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/super-admin/companies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/super-admin/companies/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/super-admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.users',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tickets/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tickets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-debug' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8VvCz2HaZtxUqdW3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-agent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DS6vJ8FZR2Ndmb0l',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/broadcasting/auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6gLtid8z1jsWLxal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/ticket(?|/([^/]++)(?|/(?|display(*:40)|re(?|mote\\-tracking(*:66)|spond(*:78)))|(*:87))|s/([^/]++)(*:105))|/a(?|pi/(?|c(?|lient/tickets/([^/]++)/respond(*:159)|ompan(?|y/([^/]++)/(?|p(?|redict/wait\\-time(*:210)|erformance/score(*:234))|analytics/load(*:257))|ies/([^/]++)/(?|performance(*:293)|queues/stats(*:313))))|services/([^/]++)/(?|call\\-next(*:355)|status(*:369))|tickets/([^/]++)/(?|re(?|spond(*:408)|call(*:420))|s(?|tatus(*:438)|erve(*:450))|miss(*:463)))|dmin/compan(?|y/([^/]++)/(?|deactivate(*:511)|activate(*:527))|ies/([^/]++)/(?|reset\\-password(?|(*:570))|auto\\-reset\\-password(*:600))))|/s(?|witch\\-company/([^/]++)(*:639)|uper\\-admin/(?|companies/([^/]++)(?|(*:683)|/edit(*:696)|(*:704))|users/([^/]++)/make\\-super\\-admin(*:746))|torage/(.*)(?|(*:769)))|/c(?|lient(?|/ticket/([^/]++)(?|(*:811)|/confirm(*:827))|\\-confirm/([^/]++)(*:854))|ompany/([^/]++)(?|/(?|public(*:891)|ticket(?|/(?|take/([^/]++)(*:925)|([^/]++)(?|(*:944)|/status(*:959)|(*:967)))|s(?|/(?|select\\-service(*:1000)|([^/]++)/track(*:1023)|take/([^/]++)(*:1045)|display(*:1061)|api/(?|currently\\-called(*:1094)|([^/]++)/status(*:1118)))|(*:1129)))|stats(*:1145)|waiting\\-tickets(*:1170)|display(*:1186)|a(?|nalytics(?|(*:1210)|/(?|real\\-time(*:1233)|export(*:1248)|widget(*:1263)|metrics(*:1279)))|dmin(?|(*:1297)|/(?|s(?|e(?|rvices(?|(*:1327)|/(?|create(*:1346)|([^/]++)(?|/edit(*:1371)|(*:1380)))|(*:1391))|ttings(*:1407))|tatistics(?|(*:1429)|/service/([^/]++)(*:1455)))|counters(?|(*:1477)|/(?|create(*:1496)|([^/]++)(?|/edit(*:1521)|(*:1530)))|(*:1541))|agents(?|(*:1560)|/(?|create(*:1579)|([^/]++)(?|/(?|edit(*:1607)|details(*:1623))|(*:1633)))|(*:1644))|work\\-schedules(?|(*:1672)|/(?|create(*:1691)|([^/]++)(?|(*:1711)|/(?|edit(*:1728)|toggle(*:1743))|(*:1753))|counter/([^/]++)(*:1779)|status/current(*:1802)|bulk\\-create(*:1823))|(*:1833))|tickets(*:1850)))|gent(?|(*:1868)|/(?|c(?|ounter/([^/]++)(?|(*:1903)|/(?|open(*:1920)|close(*:1934)|pause(*:1948)|resume(*:1963)))|all\\-next(*:1983))|service/(?|([^/]++)(*:2012)|all(*:2024))|all\\-services(*:2047)|history(*:2063)|ticket/([^/]++)/(?|present(*:2098)|serv(?|e(*:2115)|ing(*:2127))|miss(?|ed(*:2146)|(*:2155))|recall(*:2171)|transfer(?|/([^/]++)(*:2200)|(*:2209))|c(?|all(*:2226)|omplete(*:2242)))))))|(*:2257))))/?$}sDu',
    ),
    3 => 
    array (
      40 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ticket.display',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      66 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ticket.remote-tracking',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      78 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ticket.respond',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      87 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ticket',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ticket.create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      105 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.show',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.client.tickets.respond',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      210 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.predict.wait-time',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      234 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.performance.score',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      257 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.analytics.load',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      293 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XH1RgTZbXUnr4DHM',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      313 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NgW29XSa4KvfjWMJ',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      355 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2CrWhLJC2E5cZ6YH',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      369 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Jun92TpARi9ZAzIM',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BKGzAXHwBNxUZpN8',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      420 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EyFay1c0N1iE0ozU',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      438 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u9ougDMLcxAA8lsh',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      450 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CuKQBwf495E115kf',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vvWJrvi2cxl7hbIP',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      511 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.company.deactivate',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      527 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.company.activate',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      570 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.companies.reset-password',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.companies.reset-password.post',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      600 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.companies.auto-reset-password',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'switch.company',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      683 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.show',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      696 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.edit',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      704 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.update',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.companies.destroy',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      746 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'super_admin.users.make-super-admin',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      769 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local.upload',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      811 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.ticket.show',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.ticket.cancel',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      827 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.ticket.confirm',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      854 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.confirm',
          ),
          1 => 
          array (
            0 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      891 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.public',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      925 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.ticket.take',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      944 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.ticket.show',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.ticket.status',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      967 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.ticket.cancel',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1000 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.select-service',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1023 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.track',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1045 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.take',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1061 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.public-display',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1094 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.api.called',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1118 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.api.status',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1129 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets.tickets.store',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1145 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.stats',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1170 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.waiting-tickets',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1186 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.display',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1210 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.analytics.dashboard',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1233 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.analytics.realtime',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.analytics.export',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1263 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.analytics.widget',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1279 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.analytics.metrics',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.dashboard',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1327 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1346 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services.create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1371 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services.edit',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1380 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services.update',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services.destroy',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.services.store',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1407 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.settings',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1429 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.statistics',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1455 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.statistics.service',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1477 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1496 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters.create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1521 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters.edit',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1530 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters.update',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters.destroy',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1541 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.counters.store',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1560 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1579 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1607 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.edit',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'agent',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1623 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.details',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'agent',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1633 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.update',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'agent',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.update.post',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'agent',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.destroy',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'agent',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1644 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.agents.store',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1691 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1711 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.show',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'workSchedule',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1728 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.edit',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'workSchedule',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1743 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.toggle',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'workSchedule',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1753 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.update',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'workSchedule',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.destroy',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'workSchedule',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1779 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.counter',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1802 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.status',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1823 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.bulk-create',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1833 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.work-schedules.store',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1850 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.admin.admin.tickets.index',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1868 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.dashboard',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1903 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.counter',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1920 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.counter.open',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1934 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.counter.close',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1948 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.counter.pause',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1963 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.counter.resume',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'counter',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1983 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.call-next',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2012 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.service',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2024 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.service.all',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2047 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.all-services',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2063 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.history',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2098 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.present',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2115 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.serve',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2127 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.serving',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2146 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.missed',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2155 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.miss',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2171 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.recall',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2200 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.agent.ticket.transfer',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
            2 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2209 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.transfer',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2226 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.call',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2242 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.agent.ticket.complete',
          ),
          1 => 
          array (
            0 => 'company',
            1 => 'ticket',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2257 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.dashboard',
          ),
          1 => 
          array (
            0 => 'company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'generated::13AuSXuP0vEfkBp2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:840:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'C:\\\\Users\\\\FurtherMarket\\\\smartqueue-ai\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000003f00000000000000000";}}',
        'as' => 'generated::13AuSXuP0vEfkBp2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welcome' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:47:"function () {
    return \\view(\'pages.home\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000003f60000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welcome',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ticket.display' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ticket/{ticket}/display',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:986:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
    try {
        // Vérifier l\'accès par code de réponse ou par email/téléphone
        $responseCode = $request->input(\'code\');
        $email = $request->input(\'email\');
        $phone = $request->input(\'phone\');
        
        $hasAccess = false;
        
        if ($responseCode && $ticket->client_response_code === $responseCode) {
            $hasAccess = true;
        } elseif ($email && $ticket->guest_email === $email) {
            $hasAccess = true;
        } elseif ($phone && $ticket->guest_phone === $phone) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return \\response()->view(\'errors.403\', [], 403);
        }
        
        return \\view(\'client.ticket-display\', \\compact(\'ticket\'));
        
    } catch (\\Exception $e) {
        return \\response()->view(\'errors.500\', [
            \'error\' => $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000003f80000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ticket.display',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sms.test' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/sms-test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:59:"function () {
        return \\view(\'admin.sms-test\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000003fc0000000000000000";}}',
        'as' => 'admin.sms.test',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sms.test.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/sms-test/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:432:"function (\\Illuminate\\Http\\Request $request) {
        try {
            $smsService = \\app(\\App\\Services\\SMSService::class);
            $result = $smsService->send($request->phone, $request->message);
            
            return \\back()->with(\'success\', \'Message de test envoyé! Vérifiez les logs.\');
        } catch (\\Exception $e) {
            return \\back()->with(\'error\', \'Erreur: \' . $e->getMessage());
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000003fe0000000000000000";}}',
        'as' => 'admin.sms.test.send',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eZy8cjITD2sDryEI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sms-logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1209:"function () {
    // Lire les logs récents pour les SMS
    $logFile = \\storage_path(\'logs/laravel.log\');
    $logs = [];
    
    if (\\file_exists($logFile)) {
        $content = \\file_get_contents($logFile);
        $lines = \\array_reverse(\\explode("\\n", $content));
        
        foreach ($lines as $line) {
            if (\\strpos($line, \'SMS SIMULATION\') !== false || \\strpos($line, \'SMS sent\') !== false) {
                // Parser la ligne pour extraire les infos
                if (\\preg_match(\'/\\{.*\\}/\', $line, $matches)) {
                    $data = \\json_decode($matches[0], true);
                    if ($data) {
                        $logs[] = [
                            \'to\' => $data[\'to\'] ?? \'Inconnu\',
                            \'message\' => $data[\'message\'] ?? \'Message vide\',
                            \'time\' => $data[\'timestamp\'] ?? \\now()->format(\'H:i:s\'),
                            \'sent\' => \\strpos($line, \'SMS sent\') !== false
                        ];
                    }
                }
            }
            
            if (\\count($logs) >= 10) break; // Limiter à 10 logs récents
        }
    }
    
    return \\response()->json([\'logs\' => $logs]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000003fa0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::eZy8cjITD2sDryEI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LzPuTbu53L7LuNQa' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/test/ticket-call',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:996:"function (\\Illuminate\\Http\\Request $request) {
    try {
        // Créer un ticket de test
        $ticket = \\App\\Models\\Ticket::create([
            \'company_id\' => 1,
            \'service_id\' => 1,
            \'guest_phone\' => $request->phone,
            \'guest_name\' => \'Test Client\',
            \'number\' => \'TEST\' . \\rand(100, 999),
            \'status\' => \'WAITING\'
        ]);
        
        // Simuler l\'appel du ticket
        $ticket->call();
        
        // Envoyer la notification
        $notificationService = \\app(\\App\\Services\\NotificationService::class);
        $notificationService->sendTicketCalledNotification($ticket);
        
        return \\response()->json([
            \'success\' => true,
            \'ticket_id\' => $ticket->id,
            \'message\' => \'Test d\\\'appel ticket effectué\'
        ]);
    } catch (\\Exception $e) {
        return \\response()->json([
            \'success\' => false,
            \'error\' => $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004000000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::LzPuTbu53L7LuNQa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.client.tickets.respond' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/client/tickets/{ticket}/respond',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:2756:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
    try {
        $response = $request->input(\'response\');
        $delayMinutes = $request->input(\'delay_minutes\', 5);
        
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== \'CALLED\') {
            return \\response()->json([
                \'success\' => false,
                \'message\' => \'Ce ticket n\\\'est pas actuellement appelé\'
            ], 400);
        }
        
        switch ($response) {
            case \'coming\':
                $ticket->respondAsComing();
                $ticket->serve(); // Marquer comme servi immédiatement
                $message = \'Présence confirmée! Le ticket est maintenant servi.\';
                
                // Envoyer la notification à l\'agent
                $notificationService = \\app(\\App\\Services\\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, \'COMING\');
                break;
            case \'delayed\':
                $ticket->respondAsDelayed($delayMinutes);
                $message = "Noté. Retard de {$delayMinutes} minutes enregistré.";
                
                $notificationService = \\app(\\App\\Services\\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, \'DELAYED\');
                break;
            case \'not_coming\':
                $ticket->respondAsNotComing();
                $message = \'Votre ticket a été annulé.\';
                
                $notificationService = \\app(\\App\\Services\\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, \'NOT_COMING\');
                break;
            case \'need_help\':
                $ticket->respondAsNeedHelp();
                $message = \'Un agent va vous aider rapidement.\';
                
                $notificationService = \\app(\\App\\Services\\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, \'NEED_HELP\');
                break;
            default:
                return \\response()->json([
                    \'success\' => false,
                    \'message\' => \'Réponse non valide\'
                ], 400);
        }
        
        return \\response()->json([
            \'success\' => true,
            \'message\' => $message,
            \'ticket_status\' => $ticket->status,
            \'client_response\' => $ticket->getClientResponseStatus()
        ]);
        
    } catch (\\Exception $e) {
        return \\response()->json([
            \'success\' => false,
            \'message\' => \'Erreur lors de la réponse: \' . $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004020000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.client.tickets.respond',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ticket.remote-tracking' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ticket/{ticket}/remote-tracking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:987:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
    try {
        // Vérifier l\'accès par code de réponse ou par email/téléphone
        $responseCode = $request->input(\'code\');
        $email = $request->input(\'email\');
        $phone = $request->input(\'phone\');
        
        $hasAccess = false;
        
        if ($responseCode && $ticket->client_response_code === $responseCode) {
            $hasAccess = true;
        } elseif ($email && $ticket->guest_email === $email) {
            $hasAccess = true;
        } elseif ($phone && $ticket->guest_phone === $phone) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return \\response()->view(\'errors.403\', [], 403);
        }
        
        return \\view(\'client.remote-tracking\', \\compact(\'ticket\'));
        
    } catch (\\Exception $e) {
        return \\response()->view(\'errors.500\', [
            \'error\' => $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004040000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ticket.remote-tracking',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ticket.respond' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ticket/{ticket}/respond',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1249:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
    try {
        // Vérifier l\'accès par code de réponse ou par email/téléphone
        $responseCode = $request->input(\'code\');
        $email = $request->input(\'email\');
        $phone = $request->input(\'phone\');
        
        $hasAccess = false;
        
        if ($responseCode && $ticket->client_response_code === $responseCode) {
            $hasAccess = true;
        } elseif ($email && $ticket->guest_email === $email) {
            $hasAccess = true;
        } elseif ($phone && $ticket->guest_phone === $phone) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return \\response()->view(\'errors.403\', [], 403);
        }
        
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== \'CALLED\') {
            return \\response()->view(\'errors.404\', [
                \'message\' => \'Ce ticket n\\\'est pas actuellement appelé\'
            ], 404);
        }
        
        return \\view(\'client.ticket-response\', \\compact(\'ticket\'));
        
    } catch (\\Exception $e) {
        return \\response()->view(\'errors.500\', [
            \'error\' => $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004060000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ticket.respond',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'entreprises',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:52:"function () {
    return \\view(\'pages.companies\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004080000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'companies.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ticket' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ticket/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:140:"function ($companyId) {
    $company = \\App\\Models\\Company::findOrFail($companyId);
    return \\view(\'pages.ticket\', \\compact(\'company\'));
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000040a0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ticket',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.ticket' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'client/ticket',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@selectCompany',
        'controller' => 'App\\Http\\Controllers\\PublicController@selectCompany',
        'as' => 'client.ticket',
        'namespace' => NULL,
        'prefix' => '/client',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ticket.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ticket/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:3683:"function (\\App\\Models\\Company $company, \\Illuminate\\Http\\Request $request) {
    try {
        // Validation des données
        $validated = $request->validate([
            \'service\'  => \'required|exists:services,id\',
            \'name\'     => \'required|string|max:255\',
            \'phone\'    => \'nullable|string|max:20\',
            \'email\'    => \'nullable|email|max:255\',
            \'priority\' => \'required|in:normal,urgent,vip\',
        ]);

        // Vérification du service
        $service = \\App\\Models\\Service::find($validated[\'service\']);
        if (!$service) {
            return \\response()->json([
                \'success\' => false,
                \'message\' => \'Service non trouvé\'
            ], 404);
        }

        // Vérification que le service appartient à l\'entreprise
        if ($service->company_id !== $company->id) {
            return \\response()->json([
                \'success\' => false,
                \'message\' => \'Ce service n\\\'appartient pas à cette entreprise\'
            ], 400);
        }

        // Recherche d\'un compteur disponible
        $counter = \\App\\Models\\Counter::where(\'service_id\', $service->id)
            ->where(\'company_id\', $company->id)
            ->where(\'status\', \'closed\')
            ->first();

        if (!$counter) {
            $counter = \\App\\Models\\Counter::where(\'service_id\', $service->id)
                ->where(\'company_id\', $company->id)
                ->first();
        }

        // Génération du numéro de ticket
        $todayTickets = \\App\\Models\\Ticket::whereDate(\'created_at\', \\today())
            ->where(\'company_id\', $company->id)
            ->count();
        $ticketNumber = $service->prefix . \\str_pad($todayTickets + 1, 3, \'0\', STR_PAD_LEFT);

        // Création du ticket
        $ticket = \\App\\Models\\Ticket::create([
            \'company_id\'   => $company->id,
            \'service_id\'   => $service->id,
            \'counter_id\'   => $counter ? $counter->id : null,
            \'number\'       => $ticketNumber,
            \'guest_name\'   => $validated[\'name\'],
            \'guest_phone\'  => $validated[\'phone\'],
            \'guest_email\'  => $validated[\'email\'] ?? null,
            \'priority\'     => $validated[\'priority\'],
            \'status\'       => \'WAITING\',
            \'created_at\'   => \\now(),
        ]);

        if (!$ticket) {
            return \\response()->json([
                \'success\' => false,
                \'message\' => \'Erreur lors de la création du ticket\'
            ], 500);
        }

        return \\response()->json([
            \'success\' => true,
            \'ticket\'  => [
                \'id\'             => $ticket->id,
                \'number\'         => $ticket->number,
                \'service\'        => $service->name,
                \'priority\'       => $ticket->priority,
                \'counter\'        => $counter ? $counter->name : null,
                \'estimated_time\' => $service->estimated_service_time ?? 15,
            ],
        ]);

    } catch (\\Illuminate\\Validation\\ValidationException $e) {
        return \\response()->json([
            \'success\' => false,
            \'message\' => \'Erreur de validation\',
            \'errors\' => $e->errors()
        ], 422);
    } catch (\\Exception $e) {
        \\Log::error(\'Erreur lors de la création du ticket: \' . $e->getMessage());
        \\Log::error(\'Stack trace: \' . $e->getTraceAsString());
        
        return \\response()->json([
            \'success\' => false,
            \'message\' => \'Erreur lors de la génération du ticket. Veuillez réessayer.\',
            \'debug\' => \\config(\'app.debug\') ? $e->getMessage() : null
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000040e0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ticket.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@showLogin',
        'controller' => 'App\\Http\\Controllers\\AuthController@showLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Wip52VSq1qOslBQP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\AuthController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Wip52VSq1qOslBQP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'is.super.admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@showRegister',
        'controller' => 'App\\Http\\Controllers\\AuthController@showRegister',
        'as' => 'admin.register',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'is.super.admin',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\AuthController@register',
        'as' => 'admin.',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:157:"function () {
    \\auth()->logout();
    \\request()->session()->invalidate();
    \\request()->session()->regenerateToken();
    return \\redirect(\'/login\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004100000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:157:"function () {
    \\auth()->logout();
    \\request()->session()->invalidate();
    \\request()->session()->regenerateToken();
    return \\redirect(\'/login\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004160000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout.post',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'select.company' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'select-company',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@selectCompany',
        'controller' => 'App\\Http\\Controllers\\AuthController@selectCompany',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'select.company',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'switch.company' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'switch-company/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:572:"function (\\App\\Models\\Company $company) {
    $user = \\auth()->user();
 
    if (!$user->hasAccessToCompany($company)) {
        return \\back()->with(\'error\', \'Vous n\\\'avez pas accès à cette entreprise.\');
    }
 
    $user->setCurrentCompany($company);
    $role = $user->getRoleInCompany($company);
 
    if ($role === \'company_admin\') {
        return \\redirect()->route(\'company.admin.dashboard\', $company);
    } elseif ($role === \'agent\') {
        return \\redirect()->route(\'company.agent.dashboard\', $company);
    }
 
    return \\redirect()->route(\'welcome\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004190000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'switch.company',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.company.deactivate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/company/{company}/deactivate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:177:"function (\\App\\Models\\Company $company) {
        $company->deactivate();
        return \\back()->with(\'success\', \'Entreprise désactivée avec succès. Accès fermés.\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000041d0000000000000000";}}',
        'as' => 'admin.company.deactivate',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.company.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/company/{company}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:158:"function (\\App\\Models\\Company $company) {
        $company->activate();
        return \\back()->with(\'success\', \'Entreprise réactivée avec succès.\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000041f0000000000000000";}}',
        'as' => 'admin.company.activate',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin.companies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/companies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@companies',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@companies',
        'as' => 'admin.admin.companies.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.companies.reset-password' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/companies/{company}/reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@showResetPasswordForm',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@showResetPasswordForm',
        'as' => 'admin.companies.reset-password',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.companies.reset-password.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/companies/{company}/reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@resetPassword',
        'as' => 'admin.companies.reset-password.post',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.companies.auto-reset-password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/companies/{company}/auto-reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@autoResetPassword',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@autoResetPassword',
        'as' => 'admin.companies.auto-reset-password',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'client',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@clientDashboard',
        'controller' => 'App\\Http\\Controllers\\PublicController@clientDashboard',
        'as' => 'client.dashboard',
        'namespace' => NULL,
        'prefix' => '/client',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.ticket.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'client/ticket/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@showTicket',
        'controller' => 'App\\Http\\Controllers\\PublicController@showTicket',
        'as' => 'client.ticket.show',
        'namespace' => NULL,
        'prefix' => '/client',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.ticket.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'client/ticket/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@cancelTicket',
        'controller' => 'App\\Http\\Controllers\\PublicController@cancelTicket',
        'as' => 'client.ticket.cancel',
        'namespace' => NULL,
        'prefix' => '/client',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.ticket.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'client/ticket/{ticket}/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@confirmPresence',
        'controller' => 'App\\Http\\Controllers\\PublicController@confirmPresence',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'client.ticket.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.public' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/public',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@index',
        'controller' => 'App\\Http\\Controllers\\PublicController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.public',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.ticket.take' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/ticket/take/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@takeTicket',
        'controller' => 'App\\Http\\Controllers\\PublicController@takeTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.ticket.take',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.ticket.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/ticket/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@showTicket',
        'controller' => 'App\\Http\\Controllers\\PublicController@showTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.ticket.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.ticket.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/ticket/{ticket}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@ticketStatus',
        'controller' => 'App\\Http\\Controllers\\PublicController@ticketStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.ticket.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.ticket.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'company/{company}/ticket/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@cancelTicket',
        'controller' => 'App\\Http\\Controllers\\PublicController@cancelTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.ticket.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.stats' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@getStats',
        'controller' => 'App\\Http\\Controllers\\PublicController@getStats',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.stats',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.waiting-tickets' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/waiting-tickets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@getWaitingTickets',
        'controller' => 'App\\Http\\Controllers\\PublicController@getWaitingTickets',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.waiting-tickets',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.display' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/display',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PublicController@display',
        'controller' => 'App\\Http\\Controllers\\PublicController@display',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.display',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.analytics.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AnalyticsController@dashboard',
        'controller' => 'App\\Http\\Controllers\\AnalyticsController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.analytics.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.analytics.realtime' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/analytics/real-time',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AnalyticsController@realTimeData',
        'controller' => 'App\\Http\\Controllers\\AnalyticsController@realTimeData',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.analytics.realtime',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.analytics.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/analytics/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AnalyticsController@exportReport',
        'controller' => 'App\\Http\\Controllers\\AnalyticsController@exportReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.analytics.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.analytics.widget' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/analytics/widget',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AnalyticsController@widget',
        'controller' => 'App\\Http\\Controllers\\AnalyticsController@widget',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.analytics.widget',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.analytics.metrics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/analytics/metrics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AnalyticsController@metrics',
        'controller' => 'App\\Http\\Controllers\\AnalyticsController@metrics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.analytics.metrics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.predict.wait-time' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/company/{company}/predict/wait-time',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:174:"function (\\Company $company) {
    $predictor = \\app(\\App\\Services\\WaitTimePredictor::class);
    return \\response()->json($predictor->getAllServicesPredictions($company));
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000042e0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.predict.wait-time',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.analytics.load' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/company/{company}/analytics/load',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:160:"function (\\Company $company) {
    $analyzer = \\app(\\App\\Services\\LoadAnalyzer::class);
    return \\response()->json($analyzer->analyzeCurrentLoad($company));
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004350000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.analytics.load',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.performance.score' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/company/{company}/performance/score',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:164:"function (\\Company $company) {
    $scorer = \\app(\\App\\Services\\PerformanceScorer::class);
    return \\response()->json($scorer->calculateCompanyScore($company));
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004370000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.performance.score',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@dashboard',
        'controller' => 'App\\Http\\Controllers\\AuthController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@dashboard',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@dashboard',
        'as' => 'company.admin.dashboard',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@services',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@services',
        'as' => 'company.admin.services',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/services/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@createService',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@createService',
        'as' => 'company.admin.services.create',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@storeService',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@storeService',
        'as' => 'company.admin.services.store',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/services/{service}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@editService',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@editService',
        'as' => 'company.admin.services.edit',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'company/{company}/admin/services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@updateService',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@updateService',
        'as' => 'company.admin.services.update',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.services.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'company/{company}/admin/services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@destroyService',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@destroyService',
        'as' => 'company.admin.services.destroy',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/counters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@counters',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@counters',
        'as' => 'company.admin.counters',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/counters/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@createCounter',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@createCounter',
        'as' => 'company.admin.counters.create',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/counters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@storeCounter',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@storeCounter',
        'as' => 'company.admin.counters.store',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/counters/{counter}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@editCounter',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@editCounter',
        'as' => 'company.admin.counters.edit',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'company/{company}/admin/counters/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@updateCounter',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@updateCounter',
        'as' => 'company.admin.counters.update',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.counters.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'company/{company}/admin/counters/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@destroyCounter',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@destroyCounter',
        'as' => 'company.admin.counters.destroy',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/agents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@agents',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@agents',
        'as' => 'company.admin.agents',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/agents/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@createAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@createAgent',
        'as' => 'company.admin.agents.create',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/agents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@storeAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@storeAgent',
        'as' => 'company.admin.agents.store',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/agents/{agent}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@editAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@editAgent',
        'as' => 'company.admin.agents.edit',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'company/{company}/admin/agents/{agent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@updateAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@updateAgent',
        'as' => 'company.admin.agents.update',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.update.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/agents/{agent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@updateAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@updateAgent',
        'as' => 'company.admin.agents.update.post',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'company/{company}/admin/agents/{agent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@destroyAgent',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@destroyAgent',
        'as' => 'company.admin.agents.destroy',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.agents.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/agents/{agent}/details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@agentDetails',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@agentDetails',
        'as' => 'company.admin.agents.details',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@statistics',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@statistics',
        'as' => 'company.admin.statistics',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@index',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@index',
        'as' => 'company.admin.work-schedules',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@create',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@create',
        'as' => 'company.admin.work-schedules.create',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/work-schedules',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@store',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@store',
        'as' => 'company.admin.work-schedules.store',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules/{workSchedule}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@show',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@show',
        'as' => 'company.admin.work-schedules.show',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules/{workSchedule}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@edit',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@edit',
        'as' => 'company.admin.work-schedules.edit',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'company/{company}/admin/work-schedules/{workSchedule}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@update',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@update',
        'as' => 'company.admin.work-schedules.update',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'company/{company}/admin/work-schedules/{workSchedule}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@destroy',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@destroy',
        'as' => 'company.admin.work-schedules.destroy',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/work-schedules/{workSchedule}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@toggle',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@toggle',
        'as' => 'company.admin.work-schedules.toggle',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.counter' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules/counter/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@forCounter',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@forCounter',
        'as' => 'company.admin.work-schedules.counter',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/work-schedules/status/current',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@currentStatus',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@currentStatus',
        'as' => 'company.admin.work-schedules.status',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.work-schedules.bulk-create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/admin/work-schedules/bulk-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WorkScheduleController@bulkCreate',
        'controller' => 'App\\Http\\Controllers\\WorkScheduleController@bulkCreate',
        'as' => 'company.admin.work-schedules.bulk-create',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.statistics.service' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/statistics/service/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@serviceStatistics',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@serviceStatistics',
        'as' => 'company.admin.statistics.service',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.admin.tickets.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/tickets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@index',
        'controller' => 'App\\Http\\Controllers\\TicketController@index',
        'as' => 'company.admin.admin.tickets.index',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.admin.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'isCompanyAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyAdminController@settings',
        'controller' => 'App\\Http\\Controllers\\CompanyAdminController@settings',
        'as' => 'company.admin.settings',
        'namespace' => NULL,
        'prefix' => '/company/{company}/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.select-service' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/tickets/select-service',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@selectService',
        'controller' => 'App\\Http\\Controllers\\TicketController@selectService',
        'as' => 'tickets.select-service',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.tickets.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/tickets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@store',
        'controller' => 'App\\Http\\Controllers\\TicketController@store',
        'as' => 'tickets.tickets.store',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.track' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/tickets/{ticket}/track',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@track',
        'controller' => 'App\\Http\\Controllers\\TicketController@track',
        'as' => 'tickets.track',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.take' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/tickets/take/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@takeTicket',
        'controller' => 'App\\Http\\Controllers\\TicketController@takeTicket',
        'as' => 'tickets.take',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.public-display' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/tickets/display',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@publicDisplay',
        'controller' => 'App\\Http\\Controllers\\TicketController@publicDisplay',
        'as' => 'tickets.public-display',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.api.called' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/tickets/api/currently-called',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@apiCurrentlyCalled',
        'controller' => 'App\\Http\\Controllers\\TicketController@apiCurrentlyCalled',
        'as' => 'tickets.api.called',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.api.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/tickets/api/{ticket}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@apiStatus',
        'controller' => 'App\\Http\\Controllers\\TicketController@apiStatus',
        'as' => 'tickets.api.status',
        'namespace' => NULL,
        'prefix' => '/company/{company}/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@dashboard',
        'controller' => 'App\\Http\\Controllers\\AgentController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.counter' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent/counter/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@counter',
        'controller' => 'App\\Http\\Controllers\\AgentController@counter',
        'as' => 'company.agent.counter',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.service' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent/service/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@service',
        'controller' => 'App\\Http\\Controllers\\AgentController@service',
        'as' => 'company.agent.service',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.service.all' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent/service/all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@allServices',
        'controller' => 'App\\Http\\Controllers\\AgentController@allServices',
        'as' => 'company.agent.service.all',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.all-services' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent/all-services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@allServices',
        'controller' => 'App\\Http\\Controllers\\AgentController@allServices',
        'as' => 'company.agent.all-services',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'company/{company}/agent/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@history',
        'controller' => 'App\\Http\\Controllers\\AgentController@history',
        'as' => 'company.agent.history',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.call-next' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/call-next',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@callNext',
        'controller' => 'App\\Http\\Controllers\\TicketController@callNext',
        'as' => 'company.agent.call-next',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.present' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/present',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@markPresent',
        'controller' => 'App\\Http\\Controllers\\TicketController@markPresent',
        'as' => 'company.agent.ticket.present',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.serve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/serve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@serveTicket',
        'controller' => 'App\\Http\\Controllers\\AgentController@serveTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.ticket.serve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.serving' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/serving',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@markServing',
        'controller' => 'App\\Http\\Controllers\\TicketController@markServing',
        'as' => 'company.agent.ticket.serving',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.missed' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/missed',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@markMissed',
        'controller' => 'App\\Http\\Controllers\\TicketController@markMissed',
        'as' => 'company.agent.ticket.missed',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.recall' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/recall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@recallTicket',
        'controller' => 'App\\Http\\Controllers\\TicketController@recallTicket',
        'as' => 'company.agent.ticket.recall',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.agent.ticket.transfer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/transfer/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@transfer',
        'controller' => 'App\\Http\\Controllers\\TicketController@transfer',
        'as' => 'company.agent.agent.ticket.transfer',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.counter.open' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/counter/{counter}/open',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@openCounter',
        'controller' => 'App\\Http\\Controllers\\AgentController@openCounter',
        'as' => 'company.agent.counter.open',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.counter.close' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/counter/{counter}/close',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@closeCounter',
        'controller' => 'App\\Http\\Controllers\\AgentController@closeCounter',
        'as' => 'company.agent.counter.close',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.counter.pause' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/counter/{counter}/pause',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@pauseCounter',
        'controller' => 'App\\Http\\Controllers\\AgentController@pauseCounter',
        'as' => 'company.agent.counter.pause',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.counter.resume' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/counter/{counter}/resume',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
          3 => 'agent.only',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@resumeCounter',
        'controller' => 'App\\Http\\Controllers\\AgentController@resumeCounter',
        'as' => 'company.agent.counter.resume',
        'namespace' => NULL,
        'prefix' => '/company/{company}/agent',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.call' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/call',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@callTicket',
        'controller' => 'App\\Http\\Controllers\\AgentController@callTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.ticket.call',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@completeTicket',
        'controller' => 'App\\Http\\Controllers\\AgentController@completeTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.ticket.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.miss' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/miss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@missTicket',
        'controller' => 'App\\Http\\Controllers\\AgentController@missTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.ticket.miss',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'company.agent.ticket.transfer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'company/{company}/agent/ticket/{ticket}/transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'App\\Http\\Controllers\\AgentController@transferTicket',
        'controller' => 'App\\Http\\Controllers\\AgentController@transferTicket',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'company.agent.ticket.transfer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@dashboard',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@dashboard',
        'as' => 'super_admin.dashboard',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin/companies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@companies',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@companies',
        'as' => 'super_admin.companies',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin/companies/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@createCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@createCompany',
        'as' => 'super_admin.companies.create',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'super-admin/companies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@storeCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@storeCompany',
        'as' => 'super_admin.companies.store',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin/companies/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@showCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@showCompany',
        'as' => 'super_admin.companies.show',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin/companies/{company}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@editCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@editCompany',
        'as' => 'super_admin.companies.edit',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'super-admin/companies/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@updateCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@updateCompany',
        'as' => 'super_admin.companies.update',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.companies.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'super-admin/companies/{company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@destroyCompany',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@destroyCompany',
        'as' => 'super_admin.companies.destroy',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.users' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'super-admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@users',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@users',
        'as' => 'super_admin.users',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'super_admin.users.make-super-admin' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'super-admin/users/{user}/make-super-admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'isSuperAdmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdminController@makeSuperAdmin',
        'controller' => 'App\\Http\\Controllers\\SuperAdminController@makeSuperAdmin',
        'as' => 'super_admin.users.make-super-admin',
        'namespace' => NULL,
        'prefix' => '/super-admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@create',
        'controller' => 'App\\Http\\Controllers\\TicketController@create',
        'namespace' => NULL,
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
        'as' => 'tickets.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tickets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@store',
        'controller' => 'App\\Http\\Controllers\\TicketController@store',
        'namespace' => NULL,
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
        'as' => 'tickets.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@show',
        'controller' => 'App\\Http\\Controllers\\TicketController@show',
        'namespace' => NULL,
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
        'as' => 'tickets.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8VvCz2HaZtxUqdW3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-debug',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:312:"function () {
    return \\response()->json([
        \'debug\' => \'Test route working\',
        \'php_version\' => PHP_VERSION,
        \'laravel_version\' => \\app()->version(),
        \'user_authenticated\' => \\auth()->check(),
        \'user_id\' => \\auth()->id(),
        \'timestamp\' => \\now()->toISOString()
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004390000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::8VvCz2HaZtxUqdW3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DS6vJ8FZR2Ndmb0l' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-agent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:955:"function () {
    try {
        if (!\\auth()->check()) {
            return \\response()->json([\'error\' => \'Not authenticated\'], 401);
        }
        
        $user = \\auth()->user();
        $company = \\App\\Models\\Company::find(1);
        
        if (!$company) {
            return \\response()->json([\'error\' => \'Company not found\'], 404);
        }
        
        return \\response()->json([
            \'debug\' => \'Agent test working\',
            \'user_id\' => $user->id,
            \'user_email\' => $user->email,
            \'company_id\' => $company->id,
            \'company_name\' => $company->name,
            \'has_access\' => $user->hasAccessToCompany($company),
            \'is_agent\' => $user->isAgentInCompany($company)
        ]);
        
    } catch (\\Exception $e) {
        return \\response()->json([
            \'error\' => $e->getMessage(),
            \'file\' => $e->getFile(),
            \'line\' => $e->getLine()
        ]);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000048a0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::DS6vJ8FZR2Ndmb0l',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2CrWhLJC2E5cZ6YH' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/services/{service}/call-next',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1543:"function (\\App\\Models\\Service $service) {
        try {
            $user = \\auth()->user();
            $company = $service->company;
            
            // Vérifier que l\'utilisateur est un agent
            if (!$user->isAgentInCompany($company)) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            // Récupérer le prochain ticket en attente
            $nextTicket = $service->waitingTickets()
                ->where(\'status\', \'WAITING\')
                ->orderBy(\'created_at\', \'asc\')
                ->first();
            
            if (!$nextTicket) {
                return \\response()->json([\'message\' => \'Aucun ticket en attente\'], 404);
            }
            
            // Marquer le ticket comme appelé
            $nextTicket->update([
                \'status\' => \'CALLED\',
                \'called_at\' => \\now(),
                \'agent_id\' => $user->id,
            ]);
            
            return \\response()->json([
                \'success\' => true,
                \'ticket\' => [
                    \'id\' => $nextTicket->id,
                    \'number\' => $nextTicket->number,
                    \'service_name\' => $nextTicket->service->name,
                    \'guest_name\' => $nextTicket->guest_name,
                    \'status\' => $nextTicket->status,
                ]
            ]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000048e0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::2CrWhLJC2E5cZ6YH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BKGzAXHwBNxUZpN8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tickets/{ticket}/respond',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:2294:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur a accès à l\'entreprise
            if (!$user->hasAccessToCompany($ticket->company)) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            $response = $request->input(\'response\');
            $delayMinutes = $request->input(\'delay_minutes\', 5);
            
            switch ($response) {
                case \'coming\':
                    $ticket->respondAsComing();
                    $message = \'Merci ! Nous vous attendons.\';
                    break;
                case \'delayed\':
                    $ticket->respondAsDelayed($delayMinutes);
                    $message = "Noté. Retard de {$delayMinutes} minutes enregistré.";
                    break;
                case \'not_coming\':
                    $ticket->respondAsNotComing();
                    $message = \'Votre ticket a été annulé.\';
                    break;
                case \'need_help\':
                    $ticket->respondAsNeedHelp();
                    $message = \'Un agent va vous aider rapidement.\';
                    break;
                default:
                    return \\response()->json([\'message\' => \'Réponse invalide\'], 400);
            }
            
            // Notifier l\'agent
            \\broadcast(new \\App\\Events\\TicketUpdated($ticket, [
                \'type\' => \'client_responded\',
                \'response\' => $response,
                \'message\' => $ticket->getClientResponseStatus(),
            ]));
            
            return \\response()->json([
                \'success\' => true,
                \'message\' => $message,
                \'ticket\' => [
                    \'id\' => $ticket->id,
                    \'number\' => $ticket->number,
                    \'status\' => $ticket->status,
                    \'client_response\' => $ticket->client_response,
                    \'client_response_at\' => $ticket->client_response_at,
                ]
            ]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004900000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::BKGzAXHwBNxUZpN8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u9ougDMLcxAA8lsh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tickets/{ticket}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1725:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
        try {
            // Vérifier l\'accès par code de réponse ou par email/téléphone
            $responseCode = $request->input(\'code\');
            $email = $request->input(\'email\');
            $phone = $request->input(\'phone\');
            
            $hasAccess = false;
            
            if ($responseCode && $ticket->client_response_code === $responseCode) {
                $hasAccess = true;
            } elseif ($email && $ticket->guest_email === $email) {
                $hasAccess = true;
            } elseif ($phone && $ticket->guest_phone === $phone) {
                $hasAccess = true;
            }
            
            if (!$hasAccess) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            return \\response()->json([
                \'success\' => true,
                \'ticket\' => [
                    \'id\' => $ticket->id,
                    \'number\' => $ticket->number,
                    \'service_name\' => $ticket->service->name,
                    \'status\' => $ticket->status,
                    \'called_at\' => $ticket->called_at,
                    \'client_response\' => $ticket->client_response,
                    \'client_response_at\' => $ticket->client_response_at,
                    \'client_response_status\' => $ticket->getClientResponseStatus(),
                    \'can_respond\' => $ticket->status === \'CALLED\' && !$ticket->hasClientResponded(),
                ]
            ]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004920000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::u9ougDMLcxAA8lsh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CuKQBwf495E115kf' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tickets/{ticket}/serve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:607:"function (\\App\\Models\\Ticket $ticket) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur est l\'agent assigné
            if ($ticket->agent_id !== $user->id) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            // Marquer comme servi
            $ticket->serve();
            
            return \\response()->json([\'success\' => true]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004940000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::CuKQBwf495E115kf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vvWJrvi2cxl7hbIP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tickets/{ticket}/miss',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:616:"function (\\App\\Models\\Ticket $ticket) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur est l\'agent assigné
            if ($ticket->agent_id !== $user->id) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            // Marquer comme manqué
            $ticket->markAsMissed();
            
            return \\response()->json([\'success\' => true]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004960000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::vvWJrvi2cxl7hbIP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EyFay1c0N1iE0ozU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tickets/{ticket}/recall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1003:"function (\\App\\Models\\Ticket $ticket) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur a accès au service du ticket
            $hasAccess = \\App\\Models\\Counter::where(\'company_id\', $ticket->company_id)
                ->where(\'service_id\', $ticket->service_id)
                ->where(\'user_id\', $user->id)
                ->exists();
            
            if (!$hasAccess) {
                return \\response()->json([\'message\' => \'Accès non autorisé à ce service\'], 403);
            }
            
            // Rappeler le ticket et l\'assigner à cet agent
            $ticket->update([
                \'agent_id\' => $user->id,
                \'called_at\' => \\now(),
                \'status\' => \'CALLED\',
            ]);
            
            return \\response()->json([\'success\' => true]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004980000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::EyFay1c0N1iE0ozU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Jun92TpARi9ZAzIM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/services/{service}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:839:"function (\\App\\Models\\Service $service) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur a accès à l\'entreprise
            if (!$user->hasAccessToCompany($service->company)) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            return \\response()->json([
                \'service_id\' => $service->id,
                \'service_name\' => $service->name,
                \'waiting_count\' => $service->waitingTickets()->where(\'status\', \'WAITING\')->count(),
                \'total_today\' => $service->tickets()->whereDate(\'created_at\', \\today())->count(),
            ]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000049a0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::Jun92TpARi9ZAzIM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XH1RgTZbXUnr4DHM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/companies/{company}/performance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'belongs.to.company',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:843:"function (\\App\\Models\\Company $company) {
        try {
            $user = \\auth()->user();
            
            // Vérifier que l\'utilisateur a accès à l\'entreprise
            if (!$user->hasAccessToCompany($company)) {
                return \\response()->json([\'message\' => \'Accès non autorisé\'], 403);
            }
            
            $intelligenceService = \\app(\\App\\Services\\TicketIntelligenceService::class);
            $stats = $intelligenceService->getCompanyPerformanceStats($company);
            
            return \\response()->json([
                \'success\' => true,
                \'stats\' => $stats,
                \'timestamp\' => \\now()->toISOString(),
            ]);
            
        } catch (\\Exception $e) {
            return \\response()->json([\'message\' => $e->getMessage()], 500);
        }
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000049c0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::XH1RgTZbXUnr4DHM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NgW29XSa4KvfjWMJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/companies/{company}/queues/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:682:"function (\\App\\Models\\Company $company) {
    $services = $company->services()->withCount([\'waitingTickets\'])->get();
    
    return \\response()->json([
        \'services\' => $services->map(function ($service) {
            return [
                \'id\' => $service->id,
                \'name\' => $service->name,
                \'prefix\' => $service->prefix,
                \'waiting_count\' => $service->waiting_tickets_count,
                \'next_ticket\' => $service->prefix . \\str_pad(($service->tickets()->max(\'sequence\') ?? 0) + 1, 3, \'0\', STR_PAD_LEFT),
            ];
        }),
        \'total_waiting\' => $company->tickets()->where(\'status\', \'WAITING\')->count(),
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000048c0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::NgW29XSa4KvfjWMJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'client-confirm/{ticket}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1183:"function (\\App\\Models\\Ticket $ticket, \\Illuminate\\Http\\Request $request) {
    try {
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== \'CALLED\') {
            return \\response()->json([
                \'success\' => false,
                \'message\' => \'Ce ticket n\\\'est pas actuellement appelé\'
            ], 400);
        }
        
        // Marquer comme présent et servi
        $ticket->respondAsComing();
        $ticket->serve();
        
        // Envoyer la notification à l\'agent
        $notificationService = \\app(\\App\\Services\\NotificationService::class);
        $notificationService->sendClientResponseNotification($ticket, \'COMING\');
        
        return \\response()->json([
            \'success\' => true,
            \'message\' => \'Présence confirmée! Le ticket est maintenant servi.\',
            \'ticket_status\' => $ticket->status,
            \'client_response\' => $ticket->getClientResponseStatus()
        ]);
        
    } catch (\\Exception $e) {
        return \\response()->json([
            \'success\' => false,
            \'message\' => \'Erreur lors de la confirmation: \' . $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000049e0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'client.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6gLtid8z1jsWLxal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'broadcasting/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'controller' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'generated::6gLtid8z1jsWLxal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:56:"C:\\Users\\FurtherMarket\\smartqueue-ai\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000004ae0000000000000000";}}',
        'as' => 'storage.local',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local.upload' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:56:"C:\\Users\\FurtherMarket\\smartqueue-ai\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:325:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ReceiveFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000004b00000000000000000";}}',
        'as' => 'storage.local.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
