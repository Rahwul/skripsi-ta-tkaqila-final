import urllib.request
import os

try:
    if not os.path.exists('markdown2.py'):
        urllib.request.urlretrieve('https://raw.githubusercontent.com/trentm/python-markdown2/master/lib/markdown2.py', 'markdown2.py')
    import markdown2
    
    with open('Revisi_BAB_II_Faris.md', 'r', encoding='utf-8') as f:
        md_text = f.read()
        
    html_content = markdown2.markdown(md_text)
    
    html_doc = f"""<html>
<head>
<meta charset="utf-8">
</head>
<body>
{html_content}
</body>
</html>"""

    with open('Revisi_BAB_II_Faris_v2.doc', 'w', encoding='utf-8') as f:
        f.write(html_doc)
    print("Success")
except Exception as e:
    print(f"Error: {e}")
