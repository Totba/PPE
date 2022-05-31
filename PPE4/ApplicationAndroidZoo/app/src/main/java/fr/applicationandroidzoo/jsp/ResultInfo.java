package fr.applicationandroidzoo.jsp;

import fr.applicationandroidzoo.MainActivity;

public class ResultInfo {
    private boolean completed;
    private long workTimeInMillis;

    public ResultInfo(boolean completed, long workTimeInMillis) {
        this.completed = completed;
        this.workTimeInMillis = workTimeInMillis;
    }

    public boolean isCompleted() {
        return completed;
    }

    public long getWorkTimeInMillis() {
        return workTimeInMillis;
    }

    public String getMessage() {
        return "cancelled";
    }
}
