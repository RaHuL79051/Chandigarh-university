import tkinter as tk
import subprocess

def on_enter(e):
    e.widget['background'] = '#0052cc'
    e.widget['foreground'] = 'white'

def on_leave(e):
    if e.widget == btn1:
        e.widget['background'] = '#87CEEB'
    elif e.widget == btn2:
        e.widget['background'] = '#90EE90'
    e.widget['foreground'] = 'black'

def run_script1():
    subprocess.run(["python", "connect4_with_ai.py"])

def run_script2():
    subprocess.run(["python", "connect4.py"])

root = tk.Tk()
root.title("Connect 4 - Game Launcher")
root.geometry("400x300")
root.configure(bg="#f0f0f0")

title = tk.Label(root, text="🎮 Connect 4 Game Launcher", font=("Helvetica", 16, "bold"), bg="#f0f0f0", fg="#333")
title.pack(pady=30)

btn1 = tk.Button(root, text="🤖 Player vs AI", command=run_script1,
                 font=("Arial", 14), bg="#87CEEB", fg="black", width=20, height=2, bd=0, relief="ridge")
btn1.pack(pady=10)
btn1.bind("<Enter>", on_enter)
btn1.bind("<Leave>", on_leave)

btn2 = tk.Button(root, text="👥 Player vs Player", command=run_script2,
                 font=("Arial", 14), bg="#90EE90", fg="black", width=20, height=2, bd=0, relief="ridge")
btn2.pack(pady=10)
btn2.bind("<Enter>", on_enter)
btn2.bind("<Leave>", on_leave)

root.mainloop()
