import os
import base64
import tkinter as tk
from tkinter import filedialog
import requests
from bs4 import BeautifulSoup

def encode_images_to_base64(html_content):
    soup = BeautifulSoup(html_content, "html.parser")
    img_tags = soup.find_all("img")

    for img_tag in img_tags:
        src = img_tag.get("src")
        if src and src.startswith("http"):
            try:
                image_data = base64.b64encode(requests.get(src).content).decode("utf-8")
                img_tag["src"] = f"data:image/jpeg;base64,{image_data}"
            except Exception as e:
                print(f"Error encoding image: {str(e)}")

    return str(soup)

def select_file():
    file_path = filedialog.askopenfilename(filetypes=[("HTML files", "*.html")])
    if file_path:
        with open(file_path, "r", encoding="utf-8") as f:
            html_content = f.read()

        encoded_html = encode_images_to_base64(html_content)

        output_file_path = os.path.splitext(file_path)[0] + "_encoded.html"
        with open(output_file_path, "w", encoding="utf-8") as f:
            f.write(encoded_html)

        print(f"Images encoded and saved to {output_file_path}")

if __name__ == "__main__":
    root = tk.Tk()
    root.withdraw()  # Hide the main window

    select_file()
