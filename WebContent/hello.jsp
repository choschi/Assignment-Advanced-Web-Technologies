<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Sample Application JSP Page</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
  </head>

  <body>

    <h1>Sample Application JSP Page</h1>

    <p>
      This is the output of a JSP page that is part of the Hello, World
      application.  It displays several useful values from the request
      we are currently processing.
    </p>

<table border="0">
<tr>
  <th align="right">Context Path:</th>
  <td align="left"><%= request.getContextPath() %></td>
</tr>
<tr>
  <th align="right">Path Information:</th>
  <td align="left"><%= request.getPathInfo() %></td>
</tr>
<tr>
  <th align="right">Query String:</th>
  <td align="left"><%= request.getQueryString() %></td>
</tr>
<tr>
  <th align="right">Request Method:</th>
  <td align="left"><%= request.getMethod() %></td>
</tr>
<tr>
  <th align="right">Servlet Path:</th>
  <td align="left"><%= request.getServletPath() %></td>
</tr>
</table>

    <hr>
    <address>E. Dubuis</address>

</body>
</html>
