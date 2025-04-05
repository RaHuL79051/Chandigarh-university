import cv2

def open_camera(camera_index=0):
    """
    Opens the system camera and displays the video feed.
    Press 'q' to exit.
    
    :param camera_index: Index of the camera (default is 0 for primary camera)
    """
    cap = cv2.VideoCapture(camera_index)
    
    if not cap.isOpened():
        print("Error: Could not open camera.")
        return
    
    while True:
        ret, frame = cap.read()
        if not ret:
            print("Error: Failed to capture image.")
            break
        
        cv2.imshow('Camera Feed', frame)
        
        # Press 'q' to quit
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
    
    cap.release()
    cv2.destroyAllWindows()
    
if __name__ == "__main__":
    open_camera()
